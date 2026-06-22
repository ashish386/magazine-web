		     <section class="breadcrumb-section">
            <h2 class="sr-only">Site Breadcrumb</h2>
            <div class="container">
                <div class="breadcrumb-contents">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Order</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>
        <!-- Cart Page Start -->
        <main class="contact_area inner-page-sec-padding-bottom">
            <div class="container">
             
                <div class="row">
                  
            
			
                    <div class="col-lg-12 col-md-12 col-12 text-center">
					<h4> Order created Please pay for</h4>
                   
                                    <form action="<?php echo $payurl ?>" method="post">
                                                                                
                                        <input type="hidden" name="key" value="<?php echo $merchantkey ?>" />
                                        <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
                                        <input type="hidden" name="amount" value="<?php echo $amount ?>" />
                                        <input type="hidden" name="productinfo" value="<?php echo $product ?>" />
                                        <input type="hidden" name="firstname" value="<?php echo $name ?>" />
                                        <input type="hidden" name="email" value="<?php echo $email ?>" />
                                        <input type="hidden" name="phone" value="<?php echo $phone ?>" />
                                        <input type="hidden" name="surl" value="<?php echo $surl ?>" />
                                        <input type="hidden" name="furl" value="<?php echo $furl ?>" />
                                        <input type="hidden" name="hash" value="<?php echo $hash ?>" />
                                        <input type="hidden" name="service_provider" value="payu_paisa" />

                                        <div class="">
                                            <input type="submit" class="place-order" value="Proceed to Pay" />
                                        </div>
                                        
                                    </form>
                    </div>
            
			</div>
				
		
            </div>
        </main>
        <!-- Cart Page End -->
		
