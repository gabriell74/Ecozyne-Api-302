<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Menanam Pohon, Menanam Harapan',
                'description' => "Menanam pohon bukan hanya soal memperindah lingkungan, tapi juga investasi untuk masa depan bumi. Setiap pohon yang tumbuh akan membantu menyerap karbon dioksida dan menghasilkan oksigen yang kita hirup setiap hari.\n\nNamun, menanam pohon juga harus dilakukan dengan tepat. Kita perlu memahami jenis pohon yang cocok dengan kondisi tanah, iklim, dan lingkungan sekitar agar pertumbuhannya optimal. Misalnya, pohon trembesi cocok untuk daerah panas karena tajuknya lebar, sementara pohon mangrove sangat penting di daerah pesisir untuk mencegah abrasi.\n\nDengan menanam pohon, kita tidak hanya memperbaiki lingkungan, tapi juga menanam harapan untuk generasi mendatang.",
                'photo' => 'articles/kEDeBdUj6rRaQ7cqnAAYXQ2WQbkm0sbgmNs4gBqX.png'
            ],
            [
                'title' => 'Mengurangi Plastik Sekali Pakai di Kehidupan Sehari-hari',
                'description' => "Plastik sekali pakai menjadi salah satu penyumbang sampah terbesar di dunia. Kantong belanja, sedotan, dan botol air mineral yang kita gunakan setiap hari sering kali berakhir di laut dan mencemari ekosistem laut.\n\nUntuk mengurangi dampaknya, kita bisa memulai dengan langkah kecil seperti membawa tas belanja sendiri, menggunakan botol minum isi ulang, dan memilih produk dengan kemasan ramah lingkungan.\n\nPerubahan memang tidak terjadi dalam semalam, tapi jika jutaan orang melakukan hal kecil yang sama, hasilnya akan luar biasa bagi bumi kita.",
                'photo' => 'articles/kEDeBdUj6rRaQ7cqnAAYXQ2WQbkm0sbgmNs4gBqX.png'
            ],
            [
                'title' => 'Komunitas Ecozyne Gelar Aksi Bersih Pantai',
                'description' => "Puluhan anggota komunitas Ecozyne bersama relawan lokal berkumpul di Pantai Nirwana minggu lalu untuk menggelar aksi bersih pantai. Dalam waktu tiga jam, mereka berhasil mengumpulkan lebih dari 500 kilogram sampah plastik dan botol bekas.\n\nSelain membersihkan area pantai, kegiatan ini juga bertujuan untuk mengedukasi masyarakat sekitar agar lebih peduli terhadap kebersihan lingkungan. Beberapa anak muda bahkan mulai membuat ide proyek kecil seperti tempat sampah daur ulang dari bahan bekas.\n\nKegiatan ini menjadi bukti nyata bahwa aksi kecil jika dilakukan bersama bisa membawa perubahan besar.",
                'photo' => 'articles/kEDeBdUj6rRaQ7cqnAAYXQ2WQbkm0sbgmNs4gBqX.png'
            ],
            [
                'title' => 'Daur Ulang Kreatif: Dari Sampah Jadi Karya Seni',
                'description' => "Sampah bukan hanya sesuatu yang harus dibuang — dengan sedikit kreativitas, sampah bisa berubah menjadi karya seni yang menakjubkan. Banyak komunitas kini mulai mengajarkan bagaimana membuat dekorasi rumah, pot tanaman, atau aksesori dari bahan bekas.\n\nSelain mengurangi limbah, kegiatan ini juga dapat menjadi peluang usaha baru yang ramah lingkungan. Bayangkan botol plastik bekas yang disulap menjadi vas bunga, atau kaleng bekas yang diubah menjadi lampu gantung artistik.\n\nKreativitas adalah kunci untuk menciptakan dunia yang lebih bersih dan berkelanjutan.",
                'photo' => 'articles/kEDeBdUj6rRaQ7cqnAAYXQ2WQbkm0sbgmNs4gBqX.png'
            ],
            [
                'title' => 'Mengenal Konsep Zero Waste Lifestyle',
                'description' => "Zero waste lifestyle adalah pola hidup yang berfokus pada pengurangan sampah hingga seminimal mungkin. Prinsip utamanya adalah Refuse, Reduce, Reuse, Recycle, dan Rot. Dengan menerapkan lima langkah ini, kita bisa mengurangi sampah rumah tangga hingga 80%.\n\nMisalnya, mulai dari menolak barang gratis yang tidak dibutuhkan, membawa wadah sendiri saat membeli makanan, hingga mengomposkan sisa dapur. Gaya hidup ini memang membutuhkan komitmen, tetapi semakin banyak orang yang membuktikan bahwa ini bukan hal yang mustahil.\n\nLingkungan yang bersih dimulai dari pilihan sederhana setiap hari.",
                'photo' => 'articles/kEDeBdUj6rRaQ7cqnAAYXQ2WQbkm0sbgmNs4gBqX.png'
            ],
            [
                'title' => 'Belajar Membuat Kompos dari Sisa Dapur',
                'description' => "Sisa makanan seperti kulit buah, sayuran, dan daun kering sering kali berakhir di tempat sampah, padahal semuanya bisa diubah menjadi kompos alami yang bermanfaat. Kompos membantu memperkaya tanah dan membuat tanaman tumbuh lebih subur tanpa bahan kimia.\n\nProsesnya sederhana — cukup siapkan wadah, pisahkan bahan organik dari sampah lain, lalu biarkan terurai secara alami. Setelah 3–4 minggu, kamu akan mendapatkan pupuk organik yang siap digunakan untuk tanaman di rumah.\n\nSelain membantu lingkungan, membuat kompos juga mengurangi volume sampah dan menghemat biaya rumah tangga.",
                'photo' => 'articles/kEDeBdUj6rRaQ7cqnAAYXQ2WQbkm0sbgmNs4gBqX.png'
            ],
            [
                'title' => 'Eco Market: Pasar Ramah Lingkungan Pertama di Kota Kita',
                'description' => "Eco Market adalah inisiatif baru dari komunitas lokal yang ingin memperkenalkan konsep belanja berkelanjutan. Semua produk di sini berasal dari bahan alami, bebas plastik, dan diproduksi oleh pengrajin lokal yang menjunjung prinsip fair trade.\n\nSetiap pengunjung diminta membawa wadah sendiri untuk mengurangi kemasan sekali pakai. Selain itu, pasar ini juga menyediakan area edukasi tentang gaya hidup hijau dan workshop pembuatan produk ramah lingkungan.\n\nBelanja di Eco Market bukan hanya tentang membeli barang, tapi juga ikut mendukung perubahan positif untuk bumi.",
                'photo' => 'articles/kEDeBdUj6rRaQ7cqnAAYXQ2WQbkm0sbgmNs4gBqX.png'
            ],
            [
                'title' => 'Kenapa Kita Harus Peduli dengan Emisi Karbon?',
                'description' => "Emisi karbon adalah penyumbang utama perubahan iklim yang menyebabkan suhu bumi meningkat. Aktivitas manusia seperti penggunaan kendaraan bermotor dan pembakaran bahan bakar fosil mempercepat proses ini.\n\nDampaknya sudah kita rasakan: cuaca ekstrem, banjir di musim kemarau, dan gagal panen di berbagai daerah. Untuk mengatasinya, kita bisa mulai dari langkah kecil — beralih ke transportasi umum, menanam pohon, atau menghemat energi di rumah.\n\nBumi adalah rumah kita bersama, dan menjaga kestabilannya adalah tanggung jawab kita semua.",
                'photo' => 'articles/kEDeBdUj6rRaQ7cqnAAYXQ2WQbkm0sbgmNs4gBqX.png'
            ],
            [
                'title' => 'Berkebun di Rumah: Hobi Menyenangkan dan Menyehatkan',
                'description' => "Berkebun tidak harus dilakukan di lahan luas. Dengan pot kecil dan sedikit ruang di balkon, siapa pun bisa menciptakan kebun mini yang hijau dan menenangkan.\n\nSelain mempercantik rumah, berkebun juga bermanfaat untuk kesehatan mental karena bisa mengurangi stres dan meningkatkan fokus. Banyak orang kini mulai menanam sayuran organik sendiri, sehingga lebih hemat dan sehat.\n\nCobalah mulai dengan tanaman sederhana seperti cabai, tomat, atau daun mint. Dalam beberapa minggu, kamu akan merasakan kepuasan dari hasil tanganmu sendiri.",
                'photo' => 'articles/kEDeBdUj6rRaQ7cqnAAYXQ2WQbkm0sbgmNs4gBqX.png'
            ],
            [
                'title' => 'Kolaborasi untuk Bumi: Cerita Komunitas Ecozyne',
                'description' => "Ecozyne tidak hanya sekadar komunitas — tapi sebuah gerakan bersama yang menginspirasi. Dengan semangat kolaborasi, ratusan anggota aktif terlibat dalam berbagai kegiatan seperti penanaman pohon, edukasi lingkungan, dan pelatihan daur ulang.\n\nBanyak ide besar lahir dari percakapan sederhana di antara anggota. Mereka percaya bahwa setiap langkah kecil bisa memberi dampak besar jika dilakukan bersama.\n\nBumi membutuhkan lebih banyak orang seperti mereka: yang tidak hanya peduli, tapi juga mau bertindak nyata untuk masa depan yang lebih hijau.",
                'photo' => 'articles/kEDeBdUj6rRaQ7cqnAAYXQ2WQbkm0sbgmNs4gBqX.png'
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
