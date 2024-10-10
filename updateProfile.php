
<!-- Card Section -->
<?php include'INCLUDES/head.php' ?>
<?php 
include_once 'CONFIG/db.php';
$id = $_GET["id"];

$query = "SELECT * FROM users where id = ?";
$query_stmt = $pdo->prepare($query);
$query_stmt->execute([$id]);
$users = $query_stmt->fetchAll();

// requête pour modifier sa photo de profil


if (isset($_FILES["photo"])) {
  $file_name = $_FILES["photo"]["name"];
  $file_size = $_FILES["photo"]["size"];
  $file_tmp = $_FILES["photo"]["tmp_name"];
  $file_type = $_FILES["photo"]["type"];

  $extensions = array("jpg", "jpeg", "png");
  $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

  if (in_array($file_ext, $extensions) && $file_size < 2097152) {
    $new_file_name = md5(uniqid(rand(), true)). ".". $file_ext;
    $destination = "uploads/". $new_file_name;

    move_uploaded_file($file_tmp, $destination);

    $query_update_photo = "UPDATE users SET image =? WHERE id =
    $id";
    $update_stmt = $pdo->prepare($query_update_photo);
    $update_stmt->execute([$new_file_name, $id]);
    header("Location: profile.php");
    exit();
  } else {
    echo "Format de fichier non valide ou la taille du fichier dépasse la limite autorisée.";
  }
}

// requête pour modifier les informations de l'utilisateur


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $email = $_POST["email"];
  
  $query_update = "UPDATE users SET username =?, email =? WHERE id =?";
  $update_stmt = $pdo->prepare($query_update);

  $update_stmt->execute([$username, $email, $id]);

  $_SESSION["username"] = $username;
  $_SESSION["email"] = $email;

  header("Location: profile.php");
}



?>


<div class="max-w-4xl px-4 py-10 mx-auto sm:px-6 lg:px-8 lg:py-14">
  <form method="post">
    <!-- Card -->
    <div class="bg-white shadow rounded-xl">
      <div class="relative h-40 bg-blue-300 rounded-t-xl">
        <div class="absolute top-0 p-4 end-0">
          <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-800 bg-white border border-gray-200 rounded-lg shadow-sm gap-x-2 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
            Upload header
          </button>
        </div>
      </div>

      <div class="p-4 pt-0 sm:pt-0 sm:p-7">
        <!-- Grid -->
        <div class="space-y-4 sm:space-y-6">
          <div>
            <label class="sr-only">
              Product photo
            </label>

            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-x-5">
              <img class="relative z-10 inline-block mx-auto -mt-8 rounded-full size-24 sm:mx-0 ring-4 ring-white" src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['username']) ?>&background=random" alt="<?= htmlspecialchars($_SESSION['username']) ?>">

              <!-- <div class="mt-4 sm:mt-auto sm:mb-1.5 flex justify-center sm:justify-start gap-2">
                <a href="">
                  <button type="file" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-800 bg-white border border-gray-200 rounded-lg shadow-sm gap-x-2 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none ">
                  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                  Upload logo
                </button>
              </a>
                <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-500 bg-white border border-gray-200 rounded-lg shadow-sm gap-x-2 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none ">
                  Delete
                </button>
              </div> -->
            </div>
          </div>

          <div class="space-y-2">
            <label for="af-submit-app-project-name" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
              Nom utilisateur
            </label>

            <input id="af-submit-app-project-name" name="username" type="text" class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-11 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none " placeholder="Enter project name" required>
          </div>

          <div class="space-y-2">
            <label for="af-submit-project-url" class="inline-block text-sm font-medium text-gray-800 mt-2.5 ">
              Email
            </label>

            <input id="af-submit-project-url" name="email" type="text" class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-11 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Type here" required>
          </div>

          <div class="space-y-2">
            <label for="af-submit-app-upload-images" class="inline-block text-sm font-medium text-gray-800 mt-2.5 ">
              Choisir une photo
            </label>

            <input id="af-submit-app-upload-images" name="af-submit-app-upload-images" type="file" class="sr-only">
              <svg class="mx-auto text-gray-400 size-10 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z"/>
                <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
              </svg>
              <span class="block mt-2 text-sm text-gray-800 ">
                Browse your device or <span class="text-blue-600 group-hover:text-blue-700">drag 'n drop'</span>
              </span>
              <span class="block mt-1 text-xs text-gray-500 ">
                Maximum file size is 2 MB
              </span>

            <label for="af-submit-app-upload-images" class="block p-4 text-center border-2 border-gray-200 border-dashed rounded-lg cursor-pointer group sm:p-7 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 ">
              
            </label>
          </div> 
          <!-- <div class="space-y-2">
            <label for="af-submit-app-description" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
              Description
            </label>

            <textarea id="af-submit-app-description" class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="6" placeholder="A detailed summary will better explain your products to the audiences. Our users will see this in your dedicated product page."></textarea>
          </div> -->
        </div>
        <!-- End Grid -->

        <div class="flex justify-center mt-5 gap-x-2">
          <button type="submit" class="inline-flex items-center px-4 py-3 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg gap-x-2 hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
            Mettre a jour
          </button>
        </div>
      </div>
    </div>
    <!-- End Card -->
  </form>
</div>
<!-- End Card Section -->
<?php include'INCLUDES/footer.php' ?>