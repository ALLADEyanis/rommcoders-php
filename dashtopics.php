<?php include_once 'INCLUDES/header.php' ?>
<?php include_once 'INCLUDES/head.php' ?>


<?php include_once 'manage_topics.php'   ?>
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <!-- Card -->
  <div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
          <!-- Header -->
          <div class="grid gap-3 px-6 py-4 border-b border-gray-200 md:flex md:justify-between md:items-center">
            <div>
              <h2 class="text-xl font-semibold text-gray-800">
                Gestion sujets
              </h2>
              <p class="text-sm text-gray-600">
                Gérer les sujets.
              </p>
            </div>

            <div>
              <div class="inline-flex gap-x-2">
                <a class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-800 bg-white border border-gray-200 rounded-lg shadow-sm gap-x-2 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50" href="dashboard.php">
                  Gestion Utilisateurs
                </a>
              </div>
            </div>
          </div>
          <!-- End Header -->

          <!-- Table -->
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="py-3 ps-6 text-start">
                  <label for="hs-at-with-checkboxes-main" class="flex">
                    <input type="checkbox" class="text-blue-600 border-gray-300 rounded shrink-0 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" id="hs-at-with-checkboxes-main">
                    <span class="sr-only">Checkbox</span>
                  </label>
                </th>

                <th scope="col" class="py-3 ps-6 lg:ps-3 xl:ps-0 pe-6 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold tracking-wide text-gray-800 uppercase">
                      Nom utilisateurs
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold tracking-wide text-gray-800 uppercase">
                      Email
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold tracking-wide text-gray-800 uppercase">
                      Total sujets
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-end"></th>
              </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
              <?php foreach ($utilisateurs as $utilisateur): ?>
                <tr>
                  <td class="size-px whitespace-nowrap">
                    <div class="py-3 ps-6">
                      <label for="hs-at-with-checkboxes-<?php echo $utilisateur['id']; ?>" class="flex">
                        <input type="checkbox" class="text-blue-600 border-gray-300 rounded shrink-0 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" id="hs-at-with-checkboxes-<?php echo $utilisateur['id']; ?>">
                        <span class="sr-only">Checkbox</span>
                      </label>
                    </div>
                  </td>
                  <td class="size-px whitespace-nowrap">
                    <div class="py-3 ps-6 lg:ps-3 xl:ps-0 pe-6">
                      <div class="flex items-center gap-x-3">
                        f
                        <div class="grow">
                          <span class="block text-sm font-semibold text-gray-800"><?php echo htmlspecialchars($utilisateur['username']); ?></span>
                          <span class="block text-sm text-gray-500"></span>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="h-px w-72 whitespace-nowrap">
                    <div class="px-6 py-3">
                      <span class="block text-sm font-semibold text-gray-800"><?php echo htmlspecialchars($utilisateur['email']); ?></span>
                    </div>
                  </td>
                  <td class="size-px whitespace-nowrap">
                    <div class="px-6 py-3">
                      <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-lg font-medium bg-teal-100 text-teal-800 rounded-full">
                        
                        <?php echo (0); ?>
                      </span>
                    </div>
                  </td>
                  <td class="size-px whitespace-nowrap">
                    <div class="px-6 py-3">
                      <form action="view_topics_user.php?id<?php echo $utilisateur['id']; ?>" method="POST">
                        <input type="hidden" name="id" value="<?php echo $utilisateur['id']; ?>">
                        <input type="hidden" name="replies" value="<?php echo $total_replies ?>">
                        <span>
                          <input type="submit" class="block w-full px-4 py-3 text-sm border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" value="Voir sujet(s)"></input>
                        </span>
                      </form>
                    </div>
                  </td>
                  
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <!-- End Table -->

          <!-- Footer -->
            <?php
            // Number of users per page
            $users_per_page = 8;

            // Get the current page number
            $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

            // Calculate the offset for the query
            $offset = ($current_page - 1) * $users_per_page;

            // Fetch users with pagination
            $query = "SELECT * FROM users LIMIT :offset, :users_per_page";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':users_per_page', $users_per_page, PDO::PARAM_INT);
            $stmt->execute();
            $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Count the total number of users
            $query = "SELECT COUNT(*) as total FROM users";
            $stmt = $pdo->query($query);
            $total_users = $stmt->fetch()['total'];

            // Calculate the number of pages
            $nombre_total_pages = ceil($total_users / $users_per_page);
            ?>

            <!-- Update the pagination section -->
            <div class="grid gap-3 px-6 py-4 border-t border-gray-200 md:flex md:justify-between md:items-center">
              <div>
                <p class="text-sm text-gray-600">
                  <span class="font-semibold text-gray-800"><?php echo $total_users ?></span> membres
                </p>
              </div>

              <div>
                <div class="inline-flex gap-x-2">
                  <?php if ($current_page > 1): ?>
                    <a href="?page=<?php echo $current_page - 1; ?>" class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                      </svg>
                      Prev
                    </a>
                  <?php endif; ?>

                  <?php if ($current_page < $nombre_total_pages): ?>
                    <a href="?page=<?php echo $current_page + 1; ?>" class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                      Next
                      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                      </svg>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <!-- End Pagination Section -->
          <!-- End Footer -->
        </div>
      </div>
    </div>
  </div>
  <!-- End Card -->
</div>
<!-- End Table Section -->
<?php include_once('INCLUDES/footer.php'); ?>