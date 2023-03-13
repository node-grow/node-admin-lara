<?php

namespace NodeAdmin\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class DownloadAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'node-admin:download-assets {--proxy=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'download admin-front assets';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fs = new Filesystem();
        $release = $this->requestRelease();
        $asset = $release['assets'][0];
        $version = '';
        if ($fs->exists('version.lock')) {
            $version = $fs->get('version.lock');
        }
        if ($release['tag_name'] === $version) {
            $this->getOutput()->text('资源已是最新版本，无需更新');
            return;
        }


        $this->getOutput()->text('资源包下载中');
        $this->downloadZip($asset['browser_download_url'], sys_get_temp_dir() . '/node-admin-asset.zip');
        $fs->deleteDirectory(public_path('/admin'));

        $this->getOutput()->text('资源解压中');
        $zip = new \ZipArchive();
        $zip->open(sys_get_temp_dir() . '/node-admin-asset.zip');
        $zip->extractTo(sys_get_temp_dir() . '/node-admin-asset');
        $zip->close();

        $fs->copyDirectory(sys_get_temp_dir() . '/node-admin-asset/dist', public_path('/admin'));
        $this->getOutput()->text('资源解压完成');
        $fs->put('version.lock', $release['tag_name']);
    }

    protected function requestRelease()
    {
        $client = new Client();
        $options = [
            RequestOptions::HEADERS => [
                'X-GitHub-Api-Version: 2022-11-28',
                'User-Agent: PHP,node-admin-lara',
                'Accept: application/vnd.github+json',
            ]
        ];
        if ($this->option('proxy')) {
            $options[RequestOptions::PROXY] = $this->option('proxy');
        }
        $res = $client->get('https://api.github.com/repos/node-grow/node-admin-front/releases?per_page=1', $options);
        $res = (string)$res->getBody();
        $json = json_decode($res, true);
        if (!$json) {
            throw new \Exception('The result is not a vail json => ' . $res);
        }
        $res = $json[0];
        return $res;
    }

    protected function downloadZip($uri, $absolutePath)
    {
        // 实例化 HTTP 客户端
        $client = new Client;

        // 打开即将下载的本地文件，在该文件上打开一个流
        $resource = fopen($absolutePath, 'w');

        $options = ['sink' => $resource];
        if ($this->option('proxy')) {
            $options[RequestOptions::PROXY] = $this->option('proxy');
        }
        $client->get($uri, $options);
    }
}
