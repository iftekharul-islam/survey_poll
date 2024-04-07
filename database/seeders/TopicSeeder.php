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
      ['name' => 'History', 'description' => 'Description of History'],
      ['name' => 'National Culture', 'description' => 'Description of National Culture'],
      ['name' => 'Geo-graphical', 'description' => 'Description of Geo-graphical'],
      ['name' => 'Sports', 'description' => 'Description of Sports'],
      // Add more topics as needed
    ];

    // Seed topics
    foreach ($topics as $topic) {
      Topic::create($topic);
    }
  }
}
