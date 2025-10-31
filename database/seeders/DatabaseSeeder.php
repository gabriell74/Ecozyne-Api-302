<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            KecamatanTableSeeder::class,
            KelurahanTableSeeder::class,
            AddressTableSeeder::class,
            CommunityTableSeeder::class,
            WasteBankSubmissionTableSeeder::class,
            WasteBankTableSeeder::class,
            ActivityTableSeeder::class,
            ActivityRegistrationTableSeeder::class,
            RewardTableSeeder::class,
            ExchangeTableSeeder::class,
            ExchangeTransactionTableSeeder::class,
            ArticleTableSeeder::class,
            GalleryTableSeeder::class,
            DiscussionQuestionTableSeeder::class,
            DiscussionAnswerTableSeeder::class,
            ComicTableSeeder::class,
            ComicPhotoTableSeeder::class,
            LikesTableSeeder::class,
            PointTableSeeder::class,
            ProductTableSeeder::class,
            OrderTableSeeder::class,
            ProductTransactionTableSeeder::class,
            TrashTransactionTableSeeder::class,
        ]);
    }
}