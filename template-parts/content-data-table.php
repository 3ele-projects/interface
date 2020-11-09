          <!-- DataTales Example -->
          <?php
          global $project;


          $complete_invest = get_field('complete_invest');

          if (property_exists('project', 'posts')) :


            $current_month = date("m");

          else :

          endif;


          ?>

          <div class="table-responsive">
            <table class="table" id="dataTable_project" width="100%" cellspacing="0">
              <tr>
                <td> Marktkapitalisierung </td>
                <td class="text-right"><span class="h5 mb-0 font-weight-bold text-gray-800"><?php echo add_thousand_sep(get_field('complete_invest', $project->ID)); ?> €</span></td>
              </tr>

              <tr>
                <td> Bereits investiert </td>
                <td class="text-right"><span class="h5 mb-0 font-weight-bold text-gray-800"><?php echo add_thousand_sep($project->invests) ?> €</span></td>
              </tr>
              <tr>
                <td> Noch verfügbar </td>
                <td class="text-right"><span class="h5 mb-0 font-weight-bold text-gray-800"><?php echo add_thousand_sep($project->open_invest); ?> €</span></td>
              </tr>

              <tr>
                <td> Monatliche Rendite </td>
                <td class="text-right"><span class="h5 mb-0 font-weight-bold text-gray-800"><?php echo get_field('rendite', $project->ID); ?> %</span></td>
              </tr>
              <tr>
                <td>Anzahl Investoren</td>
                <td class="text-right"><span class="h5 mb-0 font-weight-bold text-gray-800"><?php echo   $project->user_complete; ?> </span></td>
              </tr>
              <tr>
                <td> Anzahl Investitionen </td>
                <td class="text-right"><span class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $project->trans_complete; ?> </span></td>
              </tr>

            </table>

          </div>