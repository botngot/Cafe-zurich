<?php
/**
 * Template Name: Home
 */
?>
<?php get_header(); ?>
<main>

	<?php include 'includes/module.php'; ?>	

	<section class="intro"> 
		<div class="intro__container container center">
			
			<div class="col-5 col-t-12 padding">
				<div class="intro__logo">
					<img src="<?php echo get_template_directory_uri(); ?>/img/logo--white.svg" alt="">
				</div>
				<?php the_field('intro'); ?>
			</div>

			<div class="intro__image col-7 col-t-12 padding">

				<?php 
					$image = get_field('intro_afbeelding');
					$size = 'large'; 

					if( $image ) {
						echo wp_get_attachment_image( $image, $size );
					}
				?>	
			</div>
		</div>
	</section>
	
	<section class="menukaarten">
		<div class="container center">
			<div class="col-6 col-t-12 left padding">
				<h2 class="menukaarten__title">menukaarten</h2>
				<div class="menukaarten__nl menukaarten--links">
					<?php if( have_rows('menukaarten_nl') ): 
					    while ( have_rows('menukaarten_nl') ) : the_row(); ?>
			 
						        <a href="<?php the_sub_field('bestand'); ?>" target="_blank"><?php the_sub_field('naam'); ?></a>
			 
						<?php
					    endwhile;
					endif; ?>
				</div>
				
				<button class="btn-dark"><a href="#">reserveren</a></button>
			</div>
			<div class="col-6 col-t-12 left padding menukaarten__col">
				<div class="menukaarten--afb1">
					<?php 
						$image = get_field('menukaarten_1');
						$size = 'large'; 

						if( $image ) {
							echo wp_get_attachment_image( $image, $size );
						}
					?>	
				</div>

				<div class="menukaarten--afb2">
					<?php 
						$image = get_field('menukaarten_2');
						$size = 'large'; 

						if( $image ) {
							echo wp_get_attachment_image( $image, $size );
						}
					?>	
				</div>
			</div>
		</div>
	</section>

	<section class="ambiance">
		<div class="container center">
			<h2 class="ambiance__title title--white padding">AMBIANCE</h2>
			<div class="slider__arrows"></div>
		</div>
		
		
		<?php $images = get_field('ambiance');

			if( $images ): ?>

			    <div class="carousel">
			        <?php foreach( $images as $image ): ?>
			            <div class="carousel-cell"> 
			                     <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
			               
			                <p><?php echo $image['caption']; ?></p>
			            </div>
			        <?php endforeach; ?>
			    </div>

		<?php endif; ?>

	</section>

	<section class="nieuws">
		<div class="container center padding">
			<h2 class="nieuws__title">NIEUWS</h2>
			<div class="nieuws--wrap">

				<?php

				$args = array(
					'post_type' => 'post',
					'posts_per_page' => 2 
				);
				$news_posts = new WP_Query($args);

				if($news_posts->have_posts()) : $counter = 0; ?>

					<?php while($news_posts->have_posts()): $news_posts->the_post(); ?>
						<div class="col-6 col-t-12 left nieuws__single padding">
	 						

							<div class="nieuws__afb" style="background-image: url(<?php the_post_thumbnail_url('large'); ?>)"></div> 
	 						<div class="nieuws__bottom">
								<h3 class="nieuws__bottom--title"><?php the_title(); ?></h3>
								<div class="nieuws__bottom--excerpt">
									<?php $content = get_field('content');
									echo wp_trim_words( $content , '22' ); ?>
								</div>

								<a class="nieuws__bottom--readmore" href="<?php the_permalink(); ?>">Lees verder...</a> 
							</div>

						</div>

					<?php endwhile;	?>

				<?php endif; wp_reset_postdata(); ?>
			</div>
		</div>
	</section>

	<section class="reserveren">
		<div class="container center padding">
			<div class="col-8 col-t-12 left padding">
				<h2 class="reserveren__title">reserveren?</h2>
			</div>
			<div class="col-4 col-t-12 left padding">
				<button class="btn-black"><a href="#">Klik hier</a></button>
			</div>
		</div>
		

		
	</section>

	<section class="instafeed">
		<div class="container center padding">
			<h2 class="instafeed__title padding">@cafezurich</h2>
			<div class="slider__arrows--insta"></div>
		</div>
		<div class="instagram__feed">
				
			<div class="girls" id="instafeed"></div>
        </div>
        <div class="container center">
			<button class="btn-dark instafeed__button"><a href="https://www.instagram.com/cafezurichamsterdam/" target="_blank">Volg ons</a></button>
		</div>
	</section>

	<section class="gmaps">
    <div id="map"></div>
    <script>
      function initMap() {

      	var styledMapType = new google.maps.StyledMapType(
            [
    {
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#e9e9e9"
            },
            {
                "lightness": 17
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#f5f5f5"
            },
            {
                "lightness": 20
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#ffffff"
            },
            {
                "lightness": 17
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#ffffff"
            },
            {
                "lightness": 29
            },
            {
                "weight": 0.2
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#ffffff"
            },
            {
                "lightness": 18
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#ffffff"
            },
            {
                "lightness": 16
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#f5f5f5"
            },
            {
                "lightness": 21
            }
        ]
    },
    {
        "featureType": "poi.park",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#dedede"
            },
            {
                "lightness": 21
            }
        ]
    },
    {
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "color": "#ffffff"
            },
            {
                "lightness": 16
            }
        ]
    },
    {
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "saturation": 36
            },
            {
                "color": "#333333"
            },
            {
                "lightness": 40
            }
        ]
    },
    {
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#f2f2f2"
            },
            {
                "lightness": 19
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#fefefe"
            },
            {
                "lightness": 20
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#fefefe"
            },
            {
                "lightness": 17
            },
            {
                "weight": 1.2
            }
        ]
    }
],
            {name: 'Styled Map'});
        var uluru = {lat: 52.369330, lng: 4.850901};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: uluru,
          scrollwheel: false,
          mapTypeControlOptions: {
            mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain',
                    'styled_map']
          }
        });

        map.mapTypes.set('styled_map', styledMapType);
        map.setMapTypeId('styled_map');
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmpDjRg95U1BYySBPSczhb694vKxOOHxU&callback=initMap">
    </script>
	</section>

	<section class="contact">
		<div class="container center padding">
			<div class="contact__adres col-6 col-t-12 left padding">
				<h2 class="contact__title">
					Contact
				</h2>
				<ul class="padding">
					<li><?php the_field('naam', 'option') ?></li>
					<li><?php the_field('adres', 'option') ?></li>
					<li><?php the_field('postcode_en_plaats', 'option') ?></li>
					<li><?php the_field('telefoonnummer', 'option') ?></li>
					<li><?php the_field('e-mail', 'option') ?></li>
				</ul>
			</div>
			<div class="contact__openingstijden col-6 col-t-12 left padding">
				<h2>
					Openingstijden
				</h2>
				<ul  class="padding">
					<?php if( have_rows('repeater', 'option') ): 
					    while ( have_rows('repeater', 'option') ) : the_row(); ?>
							<li>
						        <div class="contact__openingstijden--dag"><?php the_sub_field('dag'); ?></div>
						        <div class="contact__openingstijden--tijd"><?php the_sub_field('tijd'); ?></div>
							</li>
						<?php
					    endwhile;
					endif; ?>
				</ul>
			</div>

			<div class="col-12 left">
				<img src="<?php echo get_template_directory_uri(); ?>/img/oslo__logo.svg" alt="" class="oslo__logo">
				<div class="oslo__link">Kom ook eens naar <a href="http://oslobeers.nl" target="_blank">Oslo Beers</a></div>
			</div>
		</div>
	</section>


</main>
<?php get_footer(); ?>