<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TopicSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $topics = [
      ['name' => 'Topic 1', 'description' => 'Description of Topic 1'],
      ['name' => 'Topic 2', 'description' => 'Description of Topic 2'],
      // Add more topics as needed
    ];

    // Seed topics
    foreach ($topics as $topic) {
      Topic::create($topic);
    }
  }
}
