<?php include_once 'commentary_process.php' ?>
<?php
$userId = $_SESSION["user_id"];
?>

<section class="py-8 antialiased bg-white lg:py-16">
  <div class="max-w-2xl px-4 mx-auto">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-lg font-bold text-gray-900 lg:text-2xl">Discussion (<?php echo count($comments); ?>)</h2>
    </div>
    <?php if ($topic_details["username"] != $_SESSION['username']): ?>
      <form action="reply_process.php" method="post" class="mb-6">
        <div class="px-4 py-2 mb-4 bg-white border border-gray-200 rounded-lg rounded-t-lg">
          <label for="comment" class="sr-only">Votre commentaire</label>
          <textarea id="comment" rows="6" name="content"
            class="w-full px-0 text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none"
            placeholder="Écrivez un commentaire..." required></textarea>
          <input type="hidden" name="topic_id" value="<?= htmlspecialchars($topic_details['id']) ?>">
          <input type="hidden" name="parent_id" value="<?= $reply_idd ?>">
        </div>

        <?php if (isset($reply_id)): ?>
          <input type="hidden" name="reply_id" value="<?= $reply_id ?>">
        <?php endif; ?>
        <button type="submit"
          class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-500 bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800">
          Publier le commentaire
        </button>
      </form>
    <?php endif; ?>
    <?php if (empty($comments)): ?>
      <div class="p-6 mb-4 text-base text-yellow-700 bg-yellow-100 border-l-4 border-yellow-500" role="alert">
        <p class="font-bold">Aucune réponse pour ce sujet.</p>
      </div>
    <?php else: ?>
      <?php foreach ($comments as $comment): ?>
        <article class="p-6 text-base bg-white rounded-lg">
          <footer class="flex items-center justify-between mb-2">
            <div class="flex items-center">
              <p class="inline-flex items-center mr-3 text-sm font-semibold text-gray-900"><img class="w-8 h-8 mr-4 rounded-full" src="https://ui-avatars.com/api/?name=<?= urlencode($comment['username']) ?>&background=random" alt="<?= htmlspecialchars($comment['username']) ?>"><?php echo htmlspecialchars($comment['username']); ?></p>
              <p class="text-sm text-gray-600"><time pubdate datetime="<?php echo htmlspecialchars($comment['created_at']); ?>"
                  title="<?php echo htmlspecialchars(date('F jS, Y', strtotime($comment['created_at']))); ?>"><?php echo htmlspecialchars(date('Feb. j, Y', strtotime($comment['created_at']))); ?></time></p>
            </div>
            <button id="dropdownCommentButton1" data-dropdown-toggle="dropdownComment"
              class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50"
              type="button">
              <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
              </svg>
              <span class="sr-only">Comment settings</span>
            </button>
            <!-- Dropdown menu -->
            <?php if ($comment['user_id'] == $_SESSION['user_id']): ?>
              <div id="dropdownComment"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-36">
                <ul class="py-1 text-sm text-gray-700"
                  aria-labelledby="dropdownMenuIconHorizontalButton">
                  <li>
                    <a href="update.php?reply_id=<?= $comment['id'] ?>&topic_id=<?= $topic_details['id'] ?>" class="block w-full px-4 py-2 hover:bg-gray-100">Modifier</a>
                  </li>
                  <li>
                    <form action="delete_reply.php" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer cette réponse ?');">
                      <input type="hidden" name="delete_reply_id" value="<?= $comment['id'] ?>">
                      <input type="hidden" name="topic_id" value="<?= $topic_details['id'] ?>">
                      <button type="submit" class="block w-full px-4 py-2 hover:bg-gray-100">Supprimer</button>
                    </form>
                  </li>
                </ul>
              </div>
            <?php endif; ?>
          </footer>
          <p class="text-gray-500"><?php echo htmlspecialchars($comment['content']); ?></p>
          <div class="flex items-center mt-4 space-x-4">
            <a href="form-reply.php?topic_id=<?= $topic_details['id'] ?>&parent_id=<?= $comment['id'] ?>"
              class="flex items-center text-sm font-medium text-gray-500 hover:underline">
              <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
              </svg>
              Reply
            </a>
          </div>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>