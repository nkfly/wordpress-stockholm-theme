<?php

//Testimonials
if(!function_exists('qode_map_testimonials_meta_fields')) {

	function qode_map_testimonials_meta_fields()
	{

		$qodeTestimonials = new QodeMetaBox("testimonials", "Select Testimonials", "testimonials-meta");
		qode_framework()->qodeMetaBoxes->addMetaBox("testimonials", $qodeTestimonials);

		$qode_testimonial_author = new QodeMetaField("text", "qode_testimonial-author", "", "Author", "Enter the author name");
		$qodeTestimonials->addChild("qode_testimonial-author", $qode_testimonial_author);

		$qode_testimonial_job = new QodeMetaField("text", "qode_testimonial-job", "", "Job Position", "Enter the author job position");
		$qodeTestimonials->addChild("qode_testimonial-job", $qode_testimonial_job);

		$qode_testimonial_text = new QodeMetaField("textarea", "qode_testimonial-text", "", "Text", "Enter the testimonial text");
		$qodeTestimonials->addChild("qode_testimonial-text", $qode_testimonial_text);

	}
	add_action('qode_meta_boxes_map', 'qode_map_testimonials_meta_fields',50);
}