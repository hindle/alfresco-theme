<?php 
/*
 * Template Name:  Feedback Neutral
 * Template Post Type: page 
 */
get_header(); ?>

</div>

<style>
.al_form {
    margin: 0 auto;
    max-width: 700px;
}
 
.al_form p, .al_form label, .al_form input, .al_form textarea, .al_form select, .al_form h1, .al_form h2 {
    font-family: "Josefin Sans";
}

.al_form h1 {
    text-align: center;
    font-size: 51px;
    font-weight: 600;
    line-height: 1.15em;
    color: #F99584;
}

.al_form h2 {
    margin-top: 40px;
}

.al_form p {
    margin: 0px 0px 4px 0px;
}

.al_form label {
    margin: 0px 0px 4px 0px;
}

.al_form input, .al_form select, .al_form textarea {
    width: 100%;
    box-sizing: content-box;
    margin-bottom: 20px;
    font-size: 20px;
    padding: 8px;
}

.al_input-container:focus-within input, .al_input-container:focus-within select, .al_input-container:focus-within textarea {
    border-color: #f99584;
}

.al_input-container:focus-within label, .al_input-container:focus-within p {
    color: #f99584;
    font-size: 24px;
}

.al_form button[type="submit"] {
    color: white;
    padding: 10px 20px 10px 20px;
    border: none;
    background: #f99584;
    font-size: 20px;
}

.al_form a {
    color: #F99584;
}

.al_error-text {
    color: red;
}

.al_success {
    text-align: center;
    padding: 20px;
    min-height: 500px;
}

.al_success p {
    width: 100%;
    max-width: 100%;
    font-size: 32px;
    line-height: 38px;
}

#alfresco_form-error, #alfresco_form-success {
    display: none;
}
</style>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
		formSetup();
	}, false);

    function formSetup() {
        const form = document.querySelector('#alfresco_form-feedback-neutral');

        form.addEventListener('submit', (event) => {
            submitForm(event, form)
        });

    }

    function submitForm(event, form) {
        event.preventDefault();
        
        const submit = document.querySelector('#alfresco_form-submit');
        submit.disabled = true;
        submit.innerHTML = 'Submitting';

        const formData = new FormData(form);
        let data = {};
        formData.forEach((value, key) => data[key] = value);
        const body = JSON.stringify(data);

        const requestParams = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: body
        };

        const url = '/wp-admin/admin-ajax.php?action=ALFRESCO_FEEDBACK_NEUTRAL';

        fetch(url, requestParams)
        .then((response) => {
            if (!response.ok) {
                throw new Error(`ajax call failed: ${response.status}`);
            }
            submit.disabled = false;
            
            // Hide form
            form.style.display = 'none';

            // Show success message
            const successMessage = document.querySelector('#alfresco_form-success');
            successMessage.style.display = 'block';
            return;
        })
        .catch((error) => {
            console.error(error.message);

            // Show error message
            const errorMessage = document.querySelector('#alfresco_form-error');
            errorMessage.style.display = 'block';

            submit.innerHTML = 'Submit';
            submit.disabled = false;
        });
    }
</script>

<div id="rilee-content-container" class="rilee-single-page">
	<div class="rilee-container">
		<div id="rilee-content" class="rilee-full-width rilee_fullwidth_narrow">
            <div class="rilee-page-content-wrapper">
                <?php the_content(); ?>
            </div>

            <div class="al_form">
                <form id="alfresco_form-feedback-neutral">
                    <div class="al_input-container">
                        <label for="school">School</label><br>
                        <input type="text" name="school" id="school" autocomplete="off" required><br>
                    </div>

                    <div class="al_input-container">
                        <label for="workshopRating">Rate the overall workshop experience 1-5</label><br>
                        <select name="workshopRating" id="workshopRating">
                            <option value="">Please choose</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <br>
                    </div>

                    <div class="al_input-container">
                        <label for="leaderRating">Rate your workshop leader 1-5</label><br>
                        <select name="leaderRating" id="leaderRating">
                            <option value="">Please choose</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <br>
                    </div>

                    <div class="al_input-container">
                        <label for="bookingRating">Rate your booking experience 1-5</label><br>
                        <select name="bookingRating" id="bookingRating">
                            <option value="">Please choose</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <br>
                    </div>

                    <div class="al_input-container">
                        <label for="feedback">Feedback</label><br>
                        <p><i>Is there anything you would like to tell us about your workshop experience?</i></p>
                        <p><i>We are always open to feedback to continue to improve our workshop experiences.</i></p>
                        <textarea name="feedback" id="feedback" autocomplete="off"></textarea><br>
                    </div>

                    <button id="alfresco_form-submit" type="submit">Submit</button><br>
                    <div id="alfresco_form-error" class="al_error-text" style="display: none;"><p>Sorry, something went wrong, please try again.</p></div>
                </form>
                <div id="alfresco_form-success" class="al_success" style="display: none;">
                    <p>Thank you for sending us your feedback.</p>
                    <br>
                    <p>We will be in touch shortly.</p>
                </div>
            </div>

		</div>
	</div>

<?php get_footer();?>