<?php

namespace NodeAdmin\Console\Commands;

use ChinaDivisions\Division;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DistinctByDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'node-admin:distinct-by-db {--level=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将地区提取到数据库';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $time = microtime(true);
        $this->info('开始爬取，请稍候...');
        $this->createTable();

        $div = new Division(1);
        $this->fillData($div, 0, 0);
        $this->getChildrenData($div, 1);

        $this->info('爬取完成，耗时 ' . (microtime(true) - $time) . 's');

        return Command::SUCCESS;
    }

    protected function getChildrenData(Division $division, int $level)
    {
        $max_level = $this->option('level') ?: 3;
        if ($level > $max_level) {
            return;
        }
        $children = $division->children();
        foreach ($children as $child) {
            $this->fillData($child, $division->self()['divisionId'], $level);
            $this->getChildrenData($child, $level + 1);
        }
    }

    protected function fillData(Division $division, $pid, $level)
    {
        $data = $division->self();
        DB::table('districts')->insert([
            'id' => $data['divisionId'],
            'name' => $data['divisionName'],
            'tname' => $data['divisionTname'],
            'code' => $data['divisionCode'],
            'level' => $level,
            'abb_name' => $data['divisionAbbName'],
            'parent_id' => $pid,
            'isdeleted' => $data['isdeleted'] != 'false',
            'created_at' => now(),
        ]);
    }

    protected function createTable()
    {
        Schema::dropIfExists('districts');
        Schema::create('districts', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('tname')->nullable();
            $table->string('code');
            $table->integer('level');
            $table->string('abb_name')->nullable();
            $table->string('parent_id');
            $table->boolean('isdeleted');
            $table->timestamp('created_at');
        });
    }
}
