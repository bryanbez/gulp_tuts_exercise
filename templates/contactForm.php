<form id="testimonial_contact_form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">

	<div class="field-container">
		
		<input type="text" class="form-field" name="name" id="name" placeholder="Your Name">

		<small class="field-msg error" data-error="nameError">Your Name is Required</small>

	</div>


	<div class="field-container">
		
		<input type="text" class="form-field" name="email" id="email" placeholder="Your Email">
		
		<small class="field-msg error" data-error="emailError">The Email Address is not Valid</small>

	</div>

	<div class="field-container">
		
		<textarea rows="10" class="form-field" name="message" id="message" placeholder="Your Message"></textarea>
		
		<small class="field-msg error" data-error="messageError">Your Message is Required</small>

	</div>

	<div class="text-center">
		
		<div>
			
			<button type="submit" class="btn btn-default btn-lg">Submit</button>

		</div>

	

	<small class="field-msg js-form-during-submission">Processing your message&hellip;</small>

	<small class="field-msg success js-form-success">Thank you for your message</small>

	<small class="field-msg error js-form-error">There was a problem submitting your message. Try again</small>

	</div>

	<input type="hidden" name="action" value="submit_contact_form">

	<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'testimonial_nonce'); ?>">


</form>