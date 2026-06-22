
		<section class="breadcrumb-section">
			<h2 class="sr-only">Site Breadcrumb</h2>
			<div class="container">
				<div class="breadcrumb-contents">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="index.html">Home</a></li>
							<li class="breadcrumb-item active">Checkout</li>
						</ol>
					</nav>
				</div>
			</div>
		</section>
		<main id="content" class="page-section inner-page-sec-padding-bottom space-db--20">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<!-- Checkout Form s-->
						<div class="checkout-form">
							<div class="row row-40">
								<div class="col-12">
									<h1 class="quick-title">Checkout</h1>
									 <?php $session=session();
 //print_r($session->get('userdata')); 
                                            if(!$session->has('userdata')){?>
                                    <!-- Slide Down Trigger  -->
									<div class="checkout-quick-box">
										<p><i class="far fa-sticky-note"></i>Returning customer? <a href="javascript:"
												class="slide-trigger" data-target="#quick-login">Click
												here to login</a></p>
									</div>
									<!-- Slide Down Blox ==> Login Box  -->
									<div class="checkout-slidedown-box" id="quick-login">
										<?php echo form_open('loginViaCheckout'); ?>
											<div class="quick-login-form">
												<p>If you have shopped with us before, please enter your details in the
													boxes below. If you are a new
													customer
													please
													proceed to the Billing & Shipping section.</p>
												<div class="form-group">
													<label for="quick-user">Username or email *</label>
													<input type="text" placeholder="" id="quick-user" name="email" required>
												</div>
												<div class="form-group">
													<label for="quick-pass">Password *</label>
													<input type="text" placeholder="" id="quick-pass" name="password" required>
													<input type="hidden"  name="product" value="<?php $uri = service('uri'); echo $uri->getSegment(2);?>" required>
												</div>
												<div class="form-group">
													<div class="d-flex align-items-center flex-wrap">
														<input type="submit" class="btn btn-outlined me-3" value="Login" />
														<div class="d-inline-flex align-items-center">
															<input type="checkbox" id="accept_terms" class="mb-0 mx-1">
															<label for="accept_terms" class="mb-0">I’ve read and accept
																the terms &amp; conditions</label>
														</div>
													</div>
													<p><a href="javascript:" class="pass-lost mt-3">Lost your
															password?</a></p>
												</div>
											</div>
										</form>
									</div>
                                    
                                    <?php } ?> 
									
<!--									<div class="checkout-quick-box">
										<p><i class="far fa-sticky-note"></i>Have a coupon? <a href="javascript:"
												class="slide-trigger" data-target="#quick-cupon">
												Click here to enter your code</a></p>
									</div>
									
									<div class="checkout-slidedown-box" id="quick-cupon">
										<form action="https://htmldemo.net/pustok/pustok/">
											<div class="checkout_coupon">
												<input type="text" class="mb-0" placeholder="Coupon Code">
												<a href="#" class="btn btn-outlined">Apply coupon</a>
											</div>
										</form>
									</div>-->
								</div>
								</div>

								<?php if(session()->getFlashdata('error')): ?>
									<div class="alert alert-danger mb-3">
										<?php echo session()->getFlashdata('error'); ?>
									</div>
								<?php endif; ?>

								<?php if(session()->getFlashdata('success')): ?>
									<div class="alert alert-success mb-3">
										<?php echo session()->getFlashdata('success'); ?>
									</div>
								<?php endif; ?>
								<?php echo form_open('placeOrder'); ?>
								<div class="row">
									
									<div class="col-lg-7 mb--20">
										<!-- Billing Address -->
										<?php  //print_r($address); ?>
										
										<div id="billing-form" class="mb-40">
											<h4 class="checkout-title">Billing Address</h4>
											<div class="row">
												<div class="col-md-12 col-12 mb--20">
													<label>Name*</label>
													<input type="text" placeholder="First Name" name="name" value="<?php echo !$session->has('userdata')?"":$address->name; ?>" required >
												</div>
												<!--<div class="col-md-6 col-12 mb--20">
													<label>Last Name*</label>
													<input type="text" placeholder="Last Name" name="lname" value="<?php //echo !$session->has('userdata')?"":$address->lname; ?>">
												</div>
												-->
												
												<div class="col-md-6 col-12 mb--20">
													<label>Email Address*</label>
													<input type="email" placeholder="Email Address" name="email" value="<?php echo !$session->has('userdata')?"":$address->email; ?>" required>
												</div>
												<div class="col-md-6 col-12 mb--20">
													<label>Phone no*</label>
													<input type="text" placeholder="Phone number" name="phone" value="<?php echo !$session->has('userdata')?"":$address->phone; ?>" required>
												</div>
												<div class="col-12 mb--20">
													<label>Address*</label>
													<input type="text" placeholder="Address line 1" name="address" value="<?php echo !$session->has('userdata')?"":$address->address; ?>" required > 
													
												</div>
												<div class="col-md-6 col-12 mb--20">
													<label>Town/City*</label>
													<input type="text" placeholder="Town/City" name="city" value="<?php echo !$session->has('userdata')?"":$address->city; ?>" required >
												</div>
												<div class="col-md-6 col-12 mb--20">
													<label>State*</label>
													<input type="text" placeholder="State" name="state" value="<?php echo !$session->has('userdata')?"":$address->state; ?>" required >
												</div>
												<div class="col-md-6 col-12 mb--20">
													<label>Pin Code*</label>
													<input type="text" placeholder="Zip Code" name="pincode" value="<?php echo !$session->has('userdata')?"":$address->pincode; ?>" required >
												</div>
												
	<!--											<div class="col-md-6 col-12 mb--20">
													<label>Country*</label> 
													<select class="nice-select">
														<option value="india"  >India</option>
														<option value="nepal"  >Nepal</option> 
													</select>
												</div>
												<div class="col-12 mb--20 ">
													<div class="block-border check-bx-wrapper">
														<div class="check-box">
															<input type="checkbox" id="create_account">
															<label for="create_account">Create an Acount?</label>
														</div>
														<div class="check-box">
															<input type="checkbox" id="shiping_address" data-shipping>
															<label for="shiping_address">Ship to Different Address</label>
														</div>
													</div>
												</div>-->
											</div>
										</div>
										
										<!-- Shipping Address -->
	<!--									<div id="shipping-form" class="mb--40">
											<h4 class="checkout-title">Shipping Address</h4>
											<div class="row">
												<div class="col-md-6 col-12 mb--20">
													<label>First Name*</label>
													<input type="text" placeholder="First Name">
												</div>
												<div class="col-md-6 col-12 mb--20">
													<label>Last Name*</label>
													<input type="text" placeholder="Last Name">
												</div>
												<div class="col-md-6 col-12 mb--20">
													<label>Email Address*</label>
													<input type="email" placeholder="Email Address">
												</div>
												<div class="col-md-6 col-12 mb--20">
													<label>Phone no*</label>
													<input type="text" placeholder="Phone number">
												</div>
												<div class="col-12 mb--20">
													<label>Company Name</label>
													<input type="text" placeholder="Company Name">
												</div>
												<div class="col-12 mb--20">
													<label>Address*</label>
													<input type="text" placeholder="Address line 1">
													<input type="text" placeholder="Address line 2">
												</div>
												<div class="col-md-6 col-12 mb--20">
													<label>Country*</label>
													<select class="nice-select">
														<option>Bangladesh</option>
														<option>China</option>
														<option>country</option>
														<option>India</option>
														<option>Japan</option>
													</select>
												</div>
												<div class="col-md-6 col-12 mb--20">
													<label>Town/City*</label>
													<input type="text" placeholder="Town/City">
												</div>
												<div class="col-md-6 col-12 mb--20">
													<label>State*</label>
													<input type="text" placeholder="State">
												</div>
												<div class="col-md-6 col-12 mb--20">
													<label>Zip Code*</label>
													<input type="text" placeholder="Zip Code">
												</div>
											</div>
										</div>
										<div class="order-note-block mt--30">
											<label for="order-note">Order notes</label>
											<textarea id="order-note" cols="30" rows="10" class="order-note"
												placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
										</div>--> 
									</div>
									<div class="col-lg-5">
										<div class="row">
											<!-- Cart Total -->
											<div class="col-12">
												<div class="checkout-cart-total">
													<h2 class="checkout-title">YOUR ORDER</h2>
													<h4>Product <span>Total</span></h4>
													<ul>
														<li><span class="left"><?php echo $product->title; ?></span> <span
																class="right">Rs. <?php echo $product->special_price; ?></span></li>
														
													</ul>
													<p>Sub Total <span>Rs. <?php echo $product->special_price; ?></span></p>
													<p>Shipping Fee <span>Rs. 0</span></p>
													<h4>Grand Total <span>Rs. <?php echo $product->special_price; ?></span></h4>
													<div class="term-block mt-10">
														<input type="checkbox" id="accept_terms" checked disabled>
														<label for="accept_terms">Online</label>
														
													</div>
													<!--<div class="term-block">
														<input type="checkbox" id="accept_terms2">
														<label for="accept_terms2">I’ve read and accept the terms &
															conditions</label>
													</div>-->
													<?php $uri = current_url(true); ?>
												<input type="hidden" value="1" name="quantity" />
                                        <input type="hidden" value="<?php echo $uri->getSegment(2); ?>" name="product_id" />
                                        <input type="hidden" value="<?php echo !$session->has('userdata')?0:$session->get('userdata')->id; ?>" name="id" />
				<input type="hidden" name="amount" value="<?php echo $product->special_price ?>" />									
												
													<input type="submit" class="place-order w-100" value="Place order" />
													
													
                                                    
                                                    	
												</div>
											</div>
										</div>
									</div>
									
								</div>
								</form>
						</div>
					</div>
				</div>
			</div>
		</main>
		
	


	
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   





