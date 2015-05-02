<?php get_header(); ?>

  <div id="page" class="index bleft titulni">

   	<div class="inner contentheight">         


    <div class="postsIndex">
	    <div class="padding">
		<h2>O projektu</h2>     

   	
    
		<p id="o-projektu">
			<img src="<?php bloginfo('template_url'); ?>-child-krizkyavetrelci/images/medvedi-nahled.jpg" alt="Medvědi" id="o-projektu-logo" /> 
			Projekt Křížky a vetřelci mapuje drobné umění na území města Plzeň. Zaměřuje se jak na umění z doby normalizace,
			tak na sakrální památky jako jsou křížky či kapličky. Bez povšimnutí však nezůstávají ani pomníky a pamětní desky.
			Křížky a vetřelci jsou otevřeným projektem, do kterého se může zapojit každý. Víte o díle, které nám chybí v
			katalogu? Nebo o něm něco víte? <a href="mailto:krizkyavetrelci@seznam.cz">Napište nám</a> nebo se 
			<a href="https://www.facebook.com/groups/krizkyavetrelci/">zapojte na Facebooku</a>.
		</p>
		
		<div id="o-projektu-button">
			<a href="/o-projektu/" class="button">Více o projektu</a>
		</div>  
		
        <h2><a href="<?php echo get_the_permalink(2) ?>">Zprávy</a></h2>		
		
		<div class="aaa">
	  
        <?php
          $allposts = get_all_posts('post', 2);
          foreach ($allposts as $post)
          {
            switch_to_blog($post->blog_id);
            setup_postdata($post);
             
            $color = get_option('project_color', '#000');

            $tags = '';
            $posttags = get_the_tags();
            if ($posttags)
              foreach ($posttags as $posttag)
              {
                $tags .= sprintf('<a href="%s/zpravy/?filtr=tema_%s">%s</a>, ',  get_bloginfo('url'), $posttag->term_id, $posttag->name);
              }

            ?><div class="post" style="height: 360px">
              <?php the_post_thumbnail('post-index-recent'); ?>
              <div class="padding">
                <a href="<?php the_permalink() ?>" style="<?php printf('color: %s', $color) ?>"><h3><?php the_title(); ?></h3></a>
                <p><span>#</span><?php echo ($tags) ? trim($tags, ', ') : 'Příspěvek bez tagů'; ?></p>
                <p><span>Vloženo</span><?php the_date('d. m. Y'); ?></p>
                <p><span>Text</span>
                  <?php
                    $authors = get_post_meta(get_the_ID(), 'authors', true);
                    if ($authors)
                    {
                      $users = '';
                      foreach ($authors as $author_id)
                      {       
                        $user = get_userdata($author_id);
                        $users .= sprintf('<a href="%s%s/zpravy/?filtr=autor_%s">%s %s</a>, ', get_bloginfo('url'), ($project_menu) ? sprintf('/projekt/%s', $project_menu->slug): '', $author_id, $user->first_name, $user->last_name);
                      }
                      echo trim($users, ', ');
                    }
                    else
                    {
                      $user = get_userdata($post->post_author);
                      printf('<a href="%s%s/zpravy/?filtr=autor_%s">%s %s</a>', get_bloginfo('url'), ($project_menu) ? sprintf('/projekt/%s', $project_menu->slug): '', $post->post_author, $user->first_name, $user->last_name);
                    }
                  ?>
                </p>
              </div>
            </div><?php
            wp_reset_postdata();
            restore_current_blog();
          }
        ?>
		
		<div class="clear"></div>
		
	</div>
		
       <div id="titulka-zpravy-button">
        <a href="/zpravy/" class="button">Všechny zprávy</a>
       </div>	
		
		
		
		<h2>Mapa</h2>
		
		<p id="titulka-mapa">
		Aktuálně je zmapováno umístění <strong><?php echo kv_ObjektPocet() ?> děl</strong>.
		</p>
		
		<p id="titulka-mapa-img"><a href="/mapa/" title="Přejít na mapu">
			<img src="<?php bloginfo('template_url'); ?>-child-krizkyavetrelci/images/kv-mapa.jpg" alt="Mapa" /> 
		</a></p>
		
		<div id="titulka-mapa-button">
			<a href="/mapa/" class="button">Přejít na mapu</a>
		</div>
		
		<div class="clear"></div>
    
    </div>
	</div>
	
      <div id="actualprojects" class="contentheight">

        <h2>Náhodná díla</h2>

		<?php 
			$uploadDir = wp_upload_dir();
			$objects = array();
			for ($i = 0; $i<3; $i++) {
				$objects[] = kv_random_object();;
			}
			
			foreach($objects as $obj) {
				echo '<a href="/katalog/dilo/'.$obj->id.'/"><h3>'.$obj->nazev.'</h3></a>';
				
				if ($obj->img_512 != null) {
					echo '<a href="/katalog/dilo/'.$obj->id.'/">
						<img src="'.$uploadDir['baseurl'].$obj->img_512.'" alt="Ukázka díla" id="titulka-random-img" /></a>';				
				} else {
					echo '<a href="/katalog/dilo/'.$obj->id.'/">
						<img src="'.get_template_directory_uri().'-child-krizkyavetrelci/images/foto-neni-512.png" alt="Ukázka díla" id="titulka-random-img" /></a>';	
				}
				
				echo "<br /><br />";
			}
		?>
		
		<br /><br /><br /><br />
		<h2>Poslední přidané</h2>
		
		<?php
			$uploadDir = wp_upload_dir();
			$obj = kv_last_object();
			
			echo '<a href="/katalog/dilo/'.$obj->id.'/"><h3>'.$obj->nazev.'</h3></a>';
			
			if ($obj->img_512 != null) {
				echo '<a href="/katalog/dilo/'.$obj->id.'/">
					<img src="'.$uploadDir['baseurl'].$obj->img_512.'" alt="Ukázka díla" id="titulka-random-img" /></a>';				
			} else {
				echo '<a href="/katalog/dilo/'.$obj->id.'/">
					<img src="'.get_template_directory_uri().'-child-krizkyavetrelci/images/foto-neni-512.png" alt="Ukázka díla" id="titulka-random-img" /></a>';	
			}			
		?>

      </div>      
    </div>

  </div> 


<?php get_footer(); ?>