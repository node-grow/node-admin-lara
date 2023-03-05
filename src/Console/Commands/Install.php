<?php

namespace NodeAdmin\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use NodeAdminDatabase\Seeders\AddMenuManageSeeder;

class Install extends Command
{
    protected $signature="node-admin:install";
    protected $fs;

//    protected $init_call_seeder=[
//        AdminMenu::class=>AdminMenuSeeder::class,
//        AdminUser::class=>AdminUserSeeder::class,
//        Config::class=>ConfigSeeder::class,
//    ];

    public function __construct(Filesystem $fs)
    {
        parent::__construct();
        $this->fs=$fs;
    }

    public function handle()
    {
        $this->_initDatabase();
        $this->_installPassport();
        $this->_copyControllers();
        $this->_copyRoutes();
        $this->_installLang();
        $this->_linkAssets();
    }

    private function _initDatabase(){
        $this->call('migrate',['--force'=>'true']);

//        foreach ($this->init_call_seeder as $model=>$seeder){
//            /** @var Builder $query */
//            $query=call_user_func([$model,'query']);
//            if($query->count() == 0){
//                $this->call('db:seed', ['--class' =>$seeder]);
//            }
//        }
    }

    private function _copyRoutes(){
        if (!$this->fs->exists(base_path('routes/admin.php'))){
            $this->fs->copy(NODE_ADMIN_PATH.'/route/admin.php',base_path('routes/admin.php'));
            return;
        }
        $admin_content=$this->fs->get(base_path('routes/admin.php'));
        $preg='/(\/\/ auto add admin routes[\s\S]*\/\/ auto add admin routes end)/';
        preg_match($preg,$this->fs->get(NODE_ADMIN_PATH.'/route/admin.php'),$matches);
        $admin_content = preg_replace($preg, $matches[1], $admin_content);
        $admin_content = str_replace('use NodeAdmin\Http\Controllers as Controllers;', 'use App\Http\Controllers as Controllers;', $admin_content);
        $this->fs->put(base_path('routes/admin.php'), $admin_content);
    }

    private function _installPassport(){
        try{
            Passport::client()->newQuery()->where('name',config('app.name').' Admin Access Client')->firstOrFail();
        }catch (\Exception $e) {
            $provider=config('admin.auth.provider');
            $this->call('passport:keys');
            $this->call('passport:client', ['--personal' => true, '--name' => config('app.name') . ' Admin Access Client']);
            $this->call('passport:client', ['--password' => true, '--name' => config('app.name').' Admin Grant Client', '--provider' => $provider]);
        }
    }

    private function _installLang(){
        if ($this->fs->exists(lang_path('zh_CN'))){
            return;
        }
        $this->call('lang:add',['locales'=>'zh_CN']);
    }

    private function _linkAssets(){
        if ($this->fs->exists(public_path('assets/node-admin'))){
            return;
        }
        if (!$this->fs->exists(public_path('assets'))){
            $this->fs->makeDirectory(public_path('assets'));
        }
        $this->fs->relativeLink(NODE_ADMIN_PATH.'/assets',public_path('assets/node-admin'));

        // add gitignore
        if ($this->fs->exists(base_path('.gitignore'))){
            $ignores=explode("\n",$this->fs->get(base_path('.gitignore')));
            if (!in_array('/public/assets/node-admin',$ignores)){
                $ignores[]='/public/assets/node-admin';
                $this->fs->put(base_path('.gitignore'),implode("\n",$ignores));
            }
        }

    }

    private function _copyControllers(){
        if (!$this->fs->exists(app_path('Http/Controllers/Admin'))){
            $this->fs->makeDirectory(app_path('Http/Controllers/Admin'));
        }

        foreach ($this->fs->files(NODE_ADMIN_PATH.'/src/Http/Controllers/Admin') as $file) {
            $content=$this->fs->get(__DIR__.'/stubs/AdminController.php.stub');
            $namespace='App\\Http\\Controllers\\Admin';
            $classname=explode('.',$file->getBasename())[0];
            $base_class='\\NodeAdmin\\Http\\Controllers\\Admin\\'.$classname;
            $content=Str::replace([
                '{%namespace%}',
                '{%base_class%}',
                '{%classname%}',
            ],[
                $namespace,
                $base_class,
                $classname,
            ],$content);
            if ($this->fs->exists(app_path('Http/Controllers/Admin/'.$file->getBasename()))){
                continue;
            }
            $this->fs->put(app_path('Http/Controllers/Admin/'.$file->getBasename()),str_replace('namespace NodeAdmin\Http\Controllers\Admin','namespace App\Http\Controllers\Admin',$content));
        }
    }
}
