<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Comment</title>
    <link rel="icon" href="icon.web.png" type="image/gif">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<section class="bg-white dark:bg-gray-900 py-8 lg:py-16 antialiased">
  <div class="max-w-2xl mx-auto px-4">
    <!-- Profil  -->
    <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
        <div class="flex items-center mb-4">
            <img src="profil.jpg" alt="Profile Picture" class="w-12 h-12 rounded-full mr-4 object-cover">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">My name is <span class=" text-sky-800 font-mono">Fahri</span></h2>
                <p class="text-gray-600 dark:text-gray-400">Projek Web Gabut" an tok !! Monggo Komen penting seng sopan!!!</p>
            </div>
        </div>
        <!-- Ikon Sosial Media -->
        <div class="flex space-x-4 text-sm">
            <a href="https://www.instagram.com/f4ry_06" target="_blank" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <i class="fab fa-instagram fa-2x"></i>
            </a>
            <a href="https://www.tiktok.com/@fhri_061" target="_blank" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <i class="fab fa-tiktok fa-2x"></i>
            </a>
            <a href="https://www.youtube.com/channel/" target="_blank" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <i class="fab fa-youtube fa-2x"></i>
            </a>
        </div>
    </div>

    <!-- Form untuk mengirim komentar -->
    <form action="process/process_comment.php" method="POST" class="mb-6">
        <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <label for="comment" class="sr-only">Your comment</label>
            <textarea id="comment" name="comment" rows="6"
                class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                placeholder="Write a comment..." required></textarea>
        </div>
        <button type="submit"
            class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-sky-600 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
            Post comment
        </button>
    </form>

    <!-- Menampilkan komentar -->
    <?php
    include('koneksi.php');

    function display_comments($koneksi, $parent_id = null) {
        $sql = "SELECT * FROM comments WHERE parent_id " . ($parent_id ? "= ?" : "IS NULL") . " ORDER BY created_at DESC";
        $stmt = $koneksi->prepare($sql);
        if ($parent_id) {
            $stmt->bind_param("i", $parent_id);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        while($row = $result->fetch_assoc()) {
            echo '<article class="p-6 mb-3 text-base bg-white border-t border-gray-200 dark:border-gray-700 dark:bg-gray-900">';
            echo '<footer class="flex justify-between items-center mb-2">';
            echo '<div class="flex items-center">';
            echo '<p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">' . htmlspecialchars($row['username']) . '</p>';
            echo '<p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="' . $row['created_at'] . '" title="' . $row['created_at'] . '">' . date('M. d, Y', strtotime($row['created_at'])) . '</time></p>';
            echo '</div>';
            echo '<div>';
            echo '<button onclick="toggleReplyForm(' . $row['id'] . ')" class="text-blue-500 hover:text-blue-700">Reply</button>';
            echo '</div>';
            echo '</footer>';
            echo '<p class="text-gray-500 dark:text-gray-400">' . htmlspecialchars($row['comment']) . '</p>';
            
            // Reply form
            echo '<div id="reply-form-' . $row['id'] . '" class="hidden mt-4">';
            echo '<form action="process/process_comment.php" method="POST">';
            echo '<input type="hidden" name="parent_id" value="' . $row['id'] . '">';
            echo '<div class=" mb-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 ">';
            echo '<label for="reply" class="sr-only">Your reply</label>';
            echo '<textarea id="reply" name="comment" rows="3" class=" rounded-lg px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800" placeholder="Write a reply..." required></textarea>';
            echo '</div>';
            echo '<button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-sky-600 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">';
            echo 'Post reply';
            echo '</button>';
            echo '</form>';
            echo '</div>';
            
            // Recursively display replies
            display_comments($koneksi, $row['id']);
            
            echo '</article>';
        }
        
        $stmt->close();
    }

    display_comments($koneksi);

    // close koneksi
    $koneksi->close();
    ?>
  </div>
</section>

<script>
function toggleReplyForm(commentId) {
    var form = document.getElementById('reply-form-' + commentId);
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
    } else {
        form.classList.add('hidden');
    }
}
</script>
</body>
</html>
