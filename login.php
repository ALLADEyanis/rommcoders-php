<?php
include_once './INCLUDES/head.php';
?>
<?php
include_once './INCLUDES/header.php';
?>
<div class="flex items-center justify-center max-h-screen mt-5 bg-white shadow-sm ">
  <div class="p-4 sm:p-7">
    <div class="text-center">
      <h1 class="block text-2xl font-bold text-gray-800">Connexion</h1>
      <p class="mt-2 text-sm text-gray-600">
        Vous n'avez pas encore un compte ?
        <a class="font-medium text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline" href="register.php">
          incrivez-vous
        </a>
      </p>
    </div>

    <div class="mt-5">
      
      <div class="flex items-center py-3 text-xs text-gray-400 uppercase before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6">Or</div>

      <!-- Form -->
      <form action="login_process.php" method="post">
        <div class="grid gap-y-4">
          <!-- Form Group -->
          <div>
            <label for="email" class="block mb-2 text-sm">Adresse e-mail</label>
            <div class="relative">
              <input type="email" id="email" name="email" class="block w-full px-4 py-3 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" required aria-describedby="email-error">
              <div class="absolute inset-y-0 hidden pointer-events-none end-0 pe-3">
                <svg class="text-red-500 size-5" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                </svg>
              </div>
            </div>
            <p class="hidden mt-2 text-xs text-red-600" id="email-error">Veuillez inclure une adresse e-mail valide afin que nous puissions vous recontacter</p>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div>
            <label for="password" class="block mb-2 text-sm">Mot de passe</label>
            <div class="relative">
              <input type="password" id="password" name="password" class="block w-full px-4 py-3 text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" required aria-describedby="password-error">
              <div class="absolute inset-y-0 hidden pointer-events-none end-0 pe-3">
                <svg class="text-red-500 size-5" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                </svg>
              </div>
            </div>
            <p class="hidden mt-2 text-xs text-red-600" id="password-error">8+ caractères requis</p>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          
          <!-- End Form Group -->

          <!-- Checkbox -->
          <div class="flex items-center">
            <div class="flex">
              <input id="remember-me" name="remember-me" type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500">
            </div>
            <div class="ms-3">
              <label for="remember-me" class="text-sm">J'accepte les <a class="font-medium text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline" href="#">termes et conditions</a></label>
            </div>
          </div>
          <!-- End Checkbox -->

          <button type="submit" name="login" class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg gap-x-2 hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">se connecter</button>
        </div>
      </form>
      <!-- End Form -->
    </div>
  </div>
</div>