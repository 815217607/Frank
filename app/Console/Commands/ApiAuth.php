<?php

namespace App\Console\Commands;

use App\Util\Util;
use Illuminate\Console\Command;

class ApiAuthService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ApiAuth:frame {name} {--names=User}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command {User}auth.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //获取创建的服务名称 转换首字母大写
        $app = app_path();
        $project=base_path();
        $name = studly_case($this->argument('service_name'));
        $home=$this->option('home');
        //service文件是否存在
        if (!file_exists($app . '/Core/Services/' . $name . 'ServiceImpl.php')) {
            Util::createFolder($app . '/Core/Services');
            $newservice=$app . '/Core/Services/' . $name . 'ServiceImpl.php';
            $oldservice=$project.'/Tmp/service.tmp';
            Util::file_replace($oldservice,$newservice,$name);
        }

//        //是否创建facades
        if (!file_exists($app . '/Core/Facades/' . $name . 'Service.php') && $this->confirm("Don't has " . $name . "Service facade ? [y|n]"))
        {
            Util::createFolder($app . '/Core/Facades');
            $newfacade=$app . '/Core/Facades/' . $name . 'Service.php';
            $oldfacade=$project.'/Tmp/facade.tmp';
            Util::file_replace($oldfacade,$newfacade,$name);
        }
//        //是否创建服务提供者
        if (!file_exists($app . '/Providers/' . $name . 'ServiceProvider.php') && $this->confirm("Don't has " . $name . "Provider Provider ? [y|n]"))
        {
            $newprovider=$app . '/Providers/' . $name . 'ServiceProvider.php';
            $oldprovider=$project.'/Tmp/provider.tmp';
            Util::file_replace($oldprovider,$newprovider,$name);
        }
//
//        是否创建控制器
        if(!file_exists($app.'/Http/Controllers/'.$home.'/'.$name.'Controller.php')&&$this->confirm("Don't has ".$name."Controller ? [y|n]"))
        {
            Util::createFolder($app.'/Http/Controllers/'.$home);
            $newctl=$app.'/Http/Controllers/'.$home.'/'.$name.'Controller.php';
            $oldctl=$project.'/Tmp/controller.tmp';
            Util::file_replace($oldctl,$newctl,$name,str_replace('/','\\',$home),snake_case($name));
        }

//        //是否创建mode
        if(!file_exists($app.'/Models/'.$name.'.php')&&$this->confirm("Don't has ".$name." model ? [y|n]")){
            Util::createFolder($app.'/Models');
            $newmodel=$app.'/Models/'.$name.'.php';
            $oldmodel=$project.'/Tmp/model.tmp';
            Util::file_replace($oldmodel,$newmodel,$name,'',snake_case($name));
        }
//      是否创建migrations table
        if($this->confirm("Don't has ".$name." migrations ? [y|n]")){
            $this->info(strtolower($name));
            $table=strtolower($name);
//            Artisan::call('make:migration created_table_'.$table,['--create'=>$table]);
            $this->call('make:migration',['--create'=>$table],'created_table_'.$table);

//            $newfile=$project.'/database/migrations/'.date('Y_m_d_his').'_create_table_'.snake_case($name).'.php';
//            $oldfile=$project.'/Tmp/table.tmp';
//            file_replace($oldfile,$newfile,$name,'',snake_case($name));
        }
        $this->info('created service '.$name.' successfully.');
    }
}
