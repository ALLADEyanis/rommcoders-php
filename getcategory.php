<?php
              // Requête pour récupérer toutes les catégories
              $query = "SELECT id, name, description FROM categories ORDER BY name ASC";

              try {
                  $stmt = $pdo->prepare($query);
                  $stmt->execute();
                  $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
              } catch(PDOException $e) {
                  $error = $e->getMessage();
              }
              ?>
              
              <?php if (isset($categories) && $categories): ?>
                  <select id='category' name='category' class='block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500'>
                      <option selected disabled>Choisissez une catégorie</option>
                      <?php foreach ($categories as $category): ?>
                          <option value='<?= htmlspecialchars($category['id']) ?>' class="px-4 py-2 border-b border-gray-200 hover:bg-gray-100">
                            <?= htmlspecialchars($category['name']) ?>
                          </option>
                      <?php endforeach; ?>
                  </select>
              <?php elseif (isset($categories)): ?>
                  <p class='text-sm text-gray-500'>Aucune catégorie trouvée.</p>
              <?php else: ?>
                  <p class='text-sm text-red-500'>Erreur lors de la récupération des catégories : <?= htmlspecialchars($error) ?></p>
              <?php endif; ?>