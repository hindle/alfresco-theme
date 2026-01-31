<?php
/*
 * Template Name:  Invoice Enquiry
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
        const form = document.querySelector('#alfresco_form-invoice');

        form.addEventListener('submit', (event) => {
            submitInvoiceForm(event, form)
        });

        referrerFields();
    }

    function submitInvoiceForm(event, form) {
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

        const url = '/wp-admin/admin-ajax.php?action=ALFRESCO_INVOICE';

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

    function referrerFields() {
        const referrer = document.querySelector("#referrer");
        const referrerOtherContainer = document.querySelector("#al_referrer-other");
        const referrerOther = document.querySelector("#referrerOther");
        const referrerFriendContainer = document.querySelector("#al_referrer-friend");
        const referrerFriend = document.querySelector("#referrerFriend");

        referrer.addEventListener("change", (event) => {
            const value = event.target.value;

            if (value == "other") {
                referrerOtherContainer.style.display = "block";
                referrerFriend.value = "";
                referrerFriendContainer.style.display = "none";
            } else if (value == "friend") {
                referrerFriendContainer.style.display = "block";
                referrerOther.value = "";
                referrerOtherContainer.style.display = "none";
            } else {
                referrerFriend.value = "";
                referrerFriendContainer.style.display = "none";
                referrerOther.value = "";
                referrerOtherContainer.style.display = "none";
            }
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
                <form id="alfresco_form-invoice">
                    <h2>Account details</h2>
                    <div class="al_input-container">
                        <label for="plan">Plan</label><br>
                        <select name="plan" id="spaceOwner" required>
                            <option value="">Please choose</option>
                            <option value="1-form">1 form school (max 7 staff)</option>
                            <option value="2-form">2 form school (max 14 staff)</option>
                            <option value="3-form">3 form school (max 30 staff)</option>
                        </select>
                        <br>
                    </div>
                    <div class="al_input-container">
                        <label for="schoolName">School</label><br>
                        <input type="text" name="schoolName" id="schoolName" autocomplete="off" required><br>
                    </div>
                    <div class="al_input-container">
                        <label for="schoolAddress">Address</label><br>
                        <input type="text" name="schoolAddress" id="schoolAddress" autocomplete="off" required><br>
                    </div>
                    <div class="al_input-container">
                        <label for="schoolPostcode">Postcode</label><br>
                        <input type="text" name="schoolPostcode" id="schoolPostcode" autocomplete="off" required><br>
                    </div>

                    <h2>Account holder</h2>
                    <p>Details of the staff member who can access the Planning Hub and manage access for other members of staff.</p>
                    <div class="al_input-container">
                        <label for="accountName">Name</label><br>
                        <input type="text" name="accountName" id="accountName" autocomplete="off" required><br>
                    </div>
                    <div class="al_input-container">
                        <label for="accountEmail">Email</label><br>
                        <input type="text" name="accountEmail" id="accountEmail" autocomplete="email" required><br>
                    </div>

                    <h2>Payment details</h2>
                    <p>Details of the person who will handle the payment of the invoice e.g. bursar, administrator, finance or business manager.</p>
                    <div class="al_input-container">
                        <label for="adminName">Name</label><br>
                        <input type="text" name="adminName" id="adminName" autocomplete="off" required><br>
                    </div>
                    <div class="al_input-container">
                        <label for="adminEmail">Email</label><br>
                        <input type="text" name="adminEmail" id="adminEmail" autocomplete="email" required><br>
                    </div>

                    <br>

                    <div class="al_input-container">
                        <label for="referrer">How did you hear about us?</label><br>
                        <select name="referrer" id="referrer">
                            <option value="">Please choose</option>
                            <option value="social">Social media</option>
                            <option value="friend">Referred by a friend</option>
                            <option value="leaflet">Letter/leaflet</option>
                            <option value="email">Email</option>
                            <option value="google">Google search</option>
                            <option value="other">Other</option>
                        </select>
                        <br>
                    </div>
                    <div class="al_input-container" id="al_referrer-other" style="display: none;">
                        <label for="referrerOther">Tell us how!</label><br>
                        <input type="text" name="referrerOther" id="referrerOther" autocomplete="off"><br>
                    </div>
                    <div class="al_input-container" id="al_referrer-friend" style="display: none;">
                        <label for="referrerFriend">Share who and we will reward them!</label><br>
                        <input type="text" name="referrerFriend" id="referrerFriend" autocomplete="off"><br>
                    </div>
                    <div>
                        <p>All bookings are subject to our <a href="/cancellation-policy">Payments & Cancellation policy</a>.</p>
                    </div>

                    <button id="alfresco_form-submit" type="submit">Check availability</button><br>
                    <div id="alfresco_form-error" class="al_error-text" style="display: none;"><p>Sorry, something went wrong, please try again.</p></div>
                </form>
                <div id="alfresco_form-success" class="al_success" style="display: none;">
                    <p>Thank you for submitting a request for a Alfresco Hub membership!</p>
                    <br>
                    <p>We will be in touch shortly with an invoice and setup details.</p>
                </div>
            </div>

		</div>
	</div>

<?php get_footer();?>
