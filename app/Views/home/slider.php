	 
     
     <section class="hero-area hero-slider-1">
            <div class="sb-slick-slider" data-slick-setting='{
                            "autoplay": true,
                            "fade": true,
                            "autoplaySpeed": 3000,
                            "speed": 3000,
                            "slidesToShow": 1,
                            "dots":true
                            }'>
                <?php if($latestmagzine){ ?>
                <div class="single-slide bg-shade-whisper  ">
                    <div class="container">
                        <div class="home-content text-center text-sm-left position-relative">
                            <div class="hero-partial-image image-right">
                                <img src="<?php echo base_url('/uploads/slider/home-slider-2-ai.png');?>" alt="">
                            </div>
                            <div class="row g-0">
                                <div class="col-xl-6 col-md-6 col-sm-7">
                                    <div class="home-content-inner content-left-side text-start">
                                        <h1><?php echo $latestmagzine->title; ?></h1>
                                        <h2>Buy Latest Magazine Now!</h2>
                                        <a href="/checkout/<?php echo $latestmagzine->id; ?>" class="btn btn-outlined--primary">
                                            Rs <?php echo $latestmagzine->special_price; ?> - Order Now!
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                 <?php if($latestbook){ ?>
                <div class="single-slide bg-ghost-white">
                    <div class="container">
                        <div class="home-content text-center text-sm-left position-relative">
                            <div class="hero-partial-image image-left">
                                <img src="<?php echo base_url('/uploads/slider/home-slider-1-ai.png');?>" alt="">
                            </div>
                            <div class="row g-0">
                                <div class="col-xl-6 col-md-6 col-sm-7">
                                    <div class="home-content-inner content-right-side text-start">
                                        <h1><?php echo $latestbook->title; ?></h1>
                                        <h2>Buy Latest Magazine Now!</h2>
                                        <a href="/checkout/<?php echo $latestbook->id; ?>" class="btn btn-outlined--primary">
                                            Rs <?php echo $latestbook->special_price; ?> - Order Now!
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </section>