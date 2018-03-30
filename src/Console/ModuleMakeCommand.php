<?php
namespace  Trieunb\Modules\Console;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
class ModuleMakeCommand extends GeneratorCommand
{
    /**
     * Laravel version
     *
     * @var string
     */
    protected $version;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:module';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module (folder structure)';
    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Module';
    /**
     * The current stub.
     *
     * @var string
     */
    protected $currentStub;
    /**
     * Execute the console command >= L5.5.
     *
     * @return void
     */
    public function handle()
    {
        $app = app();
        $this->version = (int) str_replace('.', '', $app->version());
        // check if module exists
        if ($this->files->exists(app_path().'/Modules/'.studly_case($this->getNameInput()))) {
            return $this->error($this->type.' already exists!');
        }
        // Create Controller
        $this->generate('controller');
        // Create Model
        $this->generate('model');
        // Create Views folder
        $this->generate('view');
        // Create Routes file
        $this->generate('routes');

        $this->info($this->type .' '. studly_case($this->getNameInput()).' created successfully.');
    }
    public function fire()
    {
        return $this->handle();
    }
    protected function generate($type)
    {
        switch ($type) {
            case 'controller':
                $filename = studly_case($this->getNameInput()).ucfirst($type);
                break;
            case 'model':
                $filename = studly_case($this->getNameInput());
                break;
            case 'view':
                $filename = 'index.blade';
                break;
            case 'routes':
                $filename = 'routes';
                break;
        }
        if (! isset($folder)) {
            $folder = ($type != 'routes') ? ucfirst($type).'s\\' : '';
        }
        $qualifyClass = method_exists($this, 'qualifyClass') ? 'qualifyClass' : 'parseName';
        $name = $this->$qualifyClass('Modules\\'.studly_case(ucfirst($this->getNameInput())).'\\'.$folder.$filename);
        
        if ($this->files->exists($path = $this->getPath($name))) {
            return $this->error($this->type.' already exists!');
        }

        $this->currentStub = __DIR__.'/stubs/'.$type.'.stub';
        $this->makeDirectory($path);
        $this->files->put($path, $this->buildClass($name));
    }
    /**
     * Get the full namespace name for a given class.
     *
     * @param  string  $name
     * @return string
     */
    protected function getNamespace($name)
    {
        $name = str_replace('\\routes\\', '\\', $name);
        return trim(implode('\\', array_map('ucfirst', array_slice(explode('\\', studly_case($name)), 0, -1))), '\\');
    }
    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        return $this->replaceName($stub, $this->getNameInput())->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }
    /**
     * Replace the name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceName(&$stub, $name)
    {
        $stub = str_replace('ModuleTitle', $name, $stub);
        $stub = str_replace('ModuleUCtitle', ucfirst(studly_case($name)), $stub);
        return $this;
    }
    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = class_basename($name);
        return str_replace('ModuleClass', $class, $stub);
    }
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->currentStub;
    }
}