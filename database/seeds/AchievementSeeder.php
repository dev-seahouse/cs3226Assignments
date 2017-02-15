<?php

use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $achievements = array(
          array('title' => 'Let it begins', 'max_points' => 1, 'description' => 'Solve any 1st Kattis problem (thus having non zero point on Kattis) by Wed, 11 January 2017, 23:59 (this is after the introduction lecture).'),
          array('title' => 'Quick starter', 'max_points' => 1, 'description' => 'Score at least 30 points on Kattis (approximately 20 easiest problems worth 1.5 points, or 20*1.5 = 30 points) by the end of Week01.'),
          array('title' => 'Active in class', 'max_points' => 3, 'description' => 'Subjective title for student who participated well during various class activities (answering in-lecture questions, asking/answering questions in real life or in our Facebook group, consultations (with Steven or Wei Liang on Wed 2.30-4.30pm), active in Kattis, etc), awarded by Steven throughout the semester (max claim: 3 times/student).'),
          array('title' => 'Surprise us', 'max_points' => 3, 'description' => 'Managed to surprise the teaching staffs by giving a better/more elegant solution/pinpoint bug in lecture, etc anytime during the semester (max claim: 3 times/student).'),
          array('title' => 'High determination', 'max_points' => 1, 'description' => 'Objective title for student who always diligently solve (AC) problem B of all 10 weekly contests, be it during contest time or as homework assignment. This achievement will be auto updated by this system at the end of the semester.'),
          array('title' => 'Bookworm', 'max_points' => 1, 'description' => 'Subjective title for student who diligently study and review CP3.17 book by the end of Week12 (at least 10*1.5% - 0.5% = 14.5% score, i.e. at most one 1.0 with the rest 1.5). This achievement will be auto updated by this system at the end of the semester.'),
          array('title' => 'Kattis apprentice', 'max_points' => 6, 'description' => 'Be in top 25 (6%)/50 (5%)/100 (4%)/150 (3%)/200 (2%)/250 (1%) of <a href="https://open.kattis.com/ranklist">Kattis ranklist</a> <u>by the end of Week13</u> (this achievement will NOT be updated weekly as this will keep changing every week).'),
          array('title' => 'CodeForces Specialist', 'max_points' => 1, 'description' => 'Given to student who also join <a href="http://codeforces.com/">CodeForces</a> contests and attain rating of at least <font color="Cyan">1400 (Cyan color)</font> <u>by the end of Week13</u> (this achievement will NOT be updated weekly as this will keep changing every week).'),
          );
        
        foreach ($achievements as $achievement) { 
          DB::table('achievements')->insert(
            array( 
              'title' => $achievement['title'],
              'max_points' => $achievement['max_points'],
              'description' => $achievement['description'], 
              'created_at' => date('Y-m-d H:m:s'),
              'updated_at' => date('Y-m-d H:m:s')
            ));
        }
    }
}
