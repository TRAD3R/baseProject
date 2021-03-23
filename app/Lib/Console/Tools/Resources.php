<?php


namespace App\Console\Tools;


use App\AppHelper;
use Yii;

class Resources
{
    public function run(){
        $destination = Yii::getAlias('@Web');

        $ico_source = Yii::getAlias(AppHelper::getProjectResourcesAlias()) . '/favicon.ico';
        if(file_exists($ico_source)){
            exec('rm -f ' . $destination . '/favicon.ico');
            exec('cp ' . $ico_source . ' ' , $destination);
        }

        $sources = [
            'images',
            'fonts',
            'files'
        ];

        $resources = [
            AppHelper::getProjectResourcesAlias(),
            '@admin_resources'
        ];

        foreach ($sources as $folder){
            foreach ($resources as $resource) {
                $source = Yii::getAlias($resource) . DIRECTORY_SEPARATOR . $folder;
                if(is_dir($source)){
                    exec('cd ' . $destination . DIRECTORY_SEPARATOR . $folder . ' && ls | grep -v \'.gitignore\' | xargs rm -rf');
                    exec('cp -R ' . $source . ' ' . $destination);
                    exec('cd ..');
                }
            }

        }

    } // actionRun
}