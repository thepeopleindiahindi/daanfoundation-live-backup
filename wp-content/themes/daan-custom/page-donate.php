<?php
/**
 * Template Name: Donate
 *
 * 3-step donation form with UPI and Direct Bank Transfer.
 * Creates WooCommerce orders via daan_place_order AJAX handler.
 */
$preset_amount = isset($_GET['amount']) ? max(1, intval($_GET['amount'])) : 1000;
$preset_cause  = isset($_GET['cause']) ? sanitize_text_field($_GET['cause']) : 'Where Most Needed';
$causes        = array( 'Where Most Needed', 'Community Kitchen', 'Ramadan Iftar', 'Zakat', 'Sadaqah', 'Fidyah & Kaffarah' );
if (!in_array($preset_cause, $causes)) {
    $preset_cause = 'Where Most Needed';
}
get_header();
?>

<!-- Breadcrumbs -->
<div style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;">
	<div style="max-width:1280px;margin:0 auto;padding:12px 16px;">
		<nav style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#64748B;">
			<a href="/" style="color:#64748B;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#EA580C'" onmouseout="this.style.color='#64748B'">Home</a>
			<span>/</span>
			<span style="color:#111827;font-weight:600;">Donate</span>
		</nav>
	</div>
</div>

<!-- Hero Banner -->
<section style="background:linear-gradient(135deg, #EA580C, #F97316);position:relative;overflow:hidden;">
	<div style="position:relative;max-width:1280px;margin:0 auto;padding:48px 16px;">
		<div style="max-width:768px;">
			<h1 style="font-size:2.25rem;font-weight:800;color:#fff;line-height:1.1;margin:0 0 16px;">Make a Donation</h1>
			<p style="font-size:1.125rem;color:rgba(255,255,255,0.9);line-height:1.625;max-width:576px;margin:0;">Your generosity transforms lives. 100% of your donation goes directly to those in need.</p>
		</div>
	</div>
</section>

<!-- Plugin shortcode placeholders (uncomment when plugin is configured) -->
<!-- WooCommerce: <?php echo do_shortcode('[products limit="6" columns="3" category="donations"]'); ?> -->
<!-- GiveWP: <?php echo do_shortcode('[give_form id="DONATION_FORM_ID"]'); ?> -->

<!-- Step Progress Bar -->
<div style="max-width:800px;margin:0 auto;padding:40px 16px 0;">
	<div style="display:flex;align-items:center;justify-content:center;gap:0;margin-bottom:40px;">
		<?php
		$steps = array( 'Amount', 'Details', 'Payment' );
		foreach ( $steps as $i => $label ) :
			$num    = $i + 1;
			$is_last = $i === count( $steps ) - 1;
		?>
			<div style="display:flex;align-items:center;">
				<div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
					<div id="step-circle-<?php echo $num; ?>" style="width:40px;height:40px;border-radius:9999px;background:#F97316;color:#fff;display:flex;align-items:center;justify-content:center;font-size:0.875rem;font-weight:700;transition:background 0.3s;"><?php echo $num; ?></div>
					<span id="step-label-<?php echo $num; ?>" style="font-size:0.8125rem;font-weight:600;color:#111827;"><?php echo esc_html( $label ); ?></span>
				</div>
				<?php if ( ! $is_last ) : ?>
					<div id="step-line-<?php echo $num; ?>" style="width:80px;height:3px;background:#E5E7EB;margin:0 12px;margin-bottom:28px;border-radius:9999px;transition:background 0.3s;"></div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<!-- Donation Form -->
<div style="max-width:640px;margin:0 auto;padding:0 16px 64px;">

	<!-- STEP 1: Amount -->
	<div id="step-1">
		<div class="card-pad-responsive" style="background:#fff;border-radius:16px;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);">
			<h3 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 24px;">Choose Your Giving Type</h3>
			<div style="display:flex;gap:12px;margin-bottom:32px;">
				<button type="button" id="giving-onetime" onclick="setGivingType('one-time')" style="flex:1;padding:12px 0;border-radius:12px;border:2px solid #F97316;background:#FFF7ED;color:#EA580C;font-weight:700;font-size:0.9375rem;cursor:pointer;transition:all 0.2s;">One-Time</button>
				<button type="button" id="giving-monthly" onclick="setGivingType('monthly')" style="flex:1;padding:12px 0;border-radius:12px;border:2px solid #E2E8F0;background:#fff;color:#64748B;font-weight:600;font-size:0.9375rem;cursor:pointer;transition:all 0.2s;">Monthly</button>
			</div>

			<h3 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 16px;">Select Amount</h3>
			<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
				<?php foreach ( array( 500, 1000, 2500, 5000 ) as $amt ) : ?>
					<button type="button" onclick="selectDonateAmount(this, <?php echo $amt; ?>)" class="donate-amount-btn" data-amount="<?php echo $amt; ?>" style="padding:16px 0;border-radius:12px;font-size:1.125rem;font-weight:700;border:2px solid <?php echo $amt === 1000 ? '#F97316' : '#E2E8F0'; ?>;background:<?php echo $amt === 1000 ? '#FFF7ED' : '#fff'; ?>;color:<?php echo $amt === 1000 ? '#EA580C' : '#334155'; ?>;cursor:pointer;transition:all 0.2s;">₹<?php echo $amt; ?></button>
				<?php endforeach; ?>
			</div>
			<div style="position:relative;margin-bottom:32px;">
				<span style="position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#94A3B8;font-weight:600;font-size:1.125rem;">₹</span>
				<input type="number" id="custom-donate-amount" placeholder="Other amount" oninput="customDonateAmount(this)" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:14px 16px 14px 36px;font-size:1.125rem;font-weight:500;color:#111;transition:border-color 0.2s;">
			</div>

			<h3 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 16px;">Choose a Cause</h3>
			<div style="display:flex;flex-direction:column;gap:12px;margin-bottom:32px;">
				<?php foreach ( $causes as $cause ) :
					$is_selected = $cause === $preset_cause; ?>
					<label style="display:flex;align-items:center;gap:12px;padding:12px 16px;border-radius:12px;border:1px solid #E2E8F0;cursor:pointer;transition:border-color 0.2s,background 0.2s;background:<?php echo $is_selected ? '#FFF7ED' : '#fff'; ?>;border-color:<?php echo $is_selected ? '#F97316' : '#E2E8F0'; ?>;">
						<input type="radio" name="cause" value="<?php echo esc_attr( $cause ); ?>" <?php echo $is_selected ? 'checked' : ''; ?> onchange="selectCause(this)" style="accent-color:#F97316;width:18px;height:18px;">
						<span style="font-size:0.9375rem;font-weight:500;color:#334155;"><?php echo esc_html( $cause ); ?></span>
					</label>
				<?php endforeach; ?>
			</div>

			<button type="button" onclick="goToStep(2)" style="width:100%;border-radius:12px;background:#F97316;color:#fff;padding:16px 0;font-size:1.125rem;font-weight:700;border:none;cursor:pointer;box-shadow:0 4px 6px -1px rgba(249,115,22,0.3);transition:background 0.2s;">
				Continue — <span id="step1-amount-display">₹<?php echo number_format($preset_amount); ?></span>
			</button>
		</div>
	</div>

	<!-- STEP 2: Details -->
	<div id="step-2" style="display:none;">
		<div class="card-pad-responsive" style="background:#fff;border-radius:16px;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);">
			<h3 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 24px;">Your Details</h3>

			<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
				<div>
					<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">First Name *</label>
					<input type="text" id="donor-firstname" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;transition:border-color 0.2s;">
				</div>
				<div>
					<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Last Name *</label>
					<input type="text" id="donor-lastname" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;transition:border-color 0.2s;">
				</div>
			</div>

			<div style="margin-bottom:16px;">
				<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Email Address *</label>
				<input type="email" id="donor-email" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;transition:border-color 0.2s;">
			</div>

			<div style="margin-bottom:16px;">
				<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Phone Number (optional)</label>
				<input type="tel" id="donor-phone" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;transition:border-color 0.2s;">
			</div>

			<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
				<div>
					<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">City / Town *</label>
					<input type="text" id="donor-city" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;transition:border-color 0.2s;">
				</div>
				<div>
					<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">State *</label>
					<select id="donor-state" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;background:#fff;transition:border-color 0.2s;">
						<option value="">Select State</option>
						<option value="Andhra Pradesh">Andhra Pradesh</option>
						<option value="Arunachal Pradesh">Arunachal Pradesh</option>
						<option value="Assam">Assam</option>
						<option value="Bihar">Bihar</option>
						<option value="Chhattisgarh">Chhattisgarh</option>
						<option value="Goa">Goa</option>
						<option value="Gujarat">Gujarat</option>
						<option value="Haryana">Haryana</option>
						<option value="Himachal Pradesh">Himachal Pradesh</option>
						<option value="Jharkhand">Jharkhand</option>
						<option value="Karnataka">Karnataka</option>
						<option value="Kerala">Kerala</option>
						<option value="Madhya Pradesh">Madhya Pradesh</option>
						<option value="Maharashtra">Maharashtra</option>
						<option value="Manipur">Manipur</option>
						<option value="Meghalaya">Meghalaya</option>
						<option value="Mizoram">Mizoram</option>
						<option value="Nagaland">Nagaland</option>
						<option value="Odisha">Odisha</option>
						<option value="Punjab">Punjab</option>
						<option value="Rajasthan">Rajasthan</option>
						<option value="Sikkim">Sikkim</option>
						<option value="Tamil Nadu">Tamil Nadu</option>
						<option value="Telangana">Telangana</option>
						<option value="Tripura">Tripura</option>
						<option value="Uttar Pradesh">Uttar Pradesh</option>
						<option value="Uttarakhand">Uttarakhand</option>
						<option value="West Bengal">West Bengal</option>
						<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
						<option value="Chandigarh">Chandigarh</option>
						<option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
						<option value="Delhi">Delhi</option>
						<option value="Jammu and Kashmir">Jammu and Kashmir</option>
						<option value="Ladakh">Ladakh</option>
						<option value="Lakshadweep">Lakshadweep</option>
						<option value="Puducherry">Puducherry</option>
					</select>
				</div>
			</div>

			<div style="margin-bottom:24px;">
				<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Pincode *</label>
				<input type="text" id="donor-pincode" maxlength="6" inputmode="numeric" pattern="[0-9]{6}" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;transition:border-color 0.2s;">
			</div>

			<div style="display:flex;gap:12px;">
				<button type="button" onclick="goToStep(1)" style="flex:1;border-radius:12px;border:2px solid #E2E8F0;background:#fff;color:#475569;padding:14px 0;font-size:1rem;font-weight:600;cursor:pointer;transition:border-color 0.2s;">Back</button>
				<button type="button" onclick="validateAndGoToStep3()" style="flex:3;border-radius:12px;background:#F97316;color:#fff;padding:14px 0;font-size:1.125rem;font-weight:700;border:none;cursor:pointer;box-shadow:0 4px 6px -1px rgba(249,115,22,0.3);transition:background 0.2s;">Continue</button>
			</div>
		</div>
	</div>

	<!-- STEP 3: Payment -->
	<div id="step-3" style="display:none;">
		<div class="card-pad-responsive" style="background:#fff;border-radius:16px;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);">
			<h3 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 24px;">Confirm Your Donation</h3>

			<div style="background:#F8FAFC;border-radius:12px;padding:16px;margin-bottom:24px;">
				<div style="display:flex;justify-content:space-between;margin-bottom:8px;">
					<span style="font-size:0.9375rem;color:#64748B;">Amount:</span>
					<span id="summary-amount" style="font-size:1.125rem;font-weight:700;color:#111827;">₹<?php echo number_format($preset_amount); ?></span>
				</div>
				<div style="display:flex;justify-content:space-between;">
					<span style="font-size:0.9375rem;color:#64748B;">Cause:</span>
					<span id="summary-cause" style="font-size:1rem;font-weight:600;color:#111827;"><?php echo esc_html($preset_cause); ?></span>
				</div>
				<div style="display:flex;justify-content:space-between;margin-top:8px;">
					<span style="font-size:0.9375rem;color:#64748B;">Frequency:</span>
					<span id="summary-frequency" style="font-size:1rem;font-weight:600;color:#111827;">One-Time</span>
				</div>
			</div>

			<div style="margin-bottom:20px;">
				<label style="display:flex;align-items:flex-start;gap:12px;padding:16px;border-radius:12px;border:2px solid #F97316;background:#FFF7ED;cursor:pointer;margin-bottom:12px;" id="payment-bacs-label">
					<input type="radio" name="payment_method" value="bacs" checked onchange="selectPaymentMethod(this)" style="accent-color:#F97316;width:20px;height:20px;margin-top:2px;">
					<div>
						<span style="font-weight:700;font-size:1rem;color:#111827;">Direct Bank Transfer (NEFT)</span>
						<p style="font-size:0.8125rem;color:#64748B;margin:4px 0 0;">Transfer the donation amount to our bank account</p>
					</div>
				</label>
				<label style="display:flex;align-items:flex-start;gap:12px;padding:16px;border-radius:12px;border:2px solid #E2E8F0;background:#fff;cursor:pointer;" id="payment-upi-label">
					<input type="radio" name="payment_method" value="cheque" onchange="selectPaymentMethod(this)" style="accent-color:#F97316;width:20px;height:20px;margin-top:2px;">
					<div>
						<span style="font-weight:700;font-size:1rem;color:#111827;">Pay via UPI</span>
						<p style="font-size:0.8125rem;color:#64748B;margin:4px 0 0;">Pay using GPay / PhonePe / PayTM</p>
					</div>
				</label>
			</div>

			<div id="payment-bacs-details" style="background:#FFFBEB;border:1px solid #FDE68A;border-radius:12px;padding:20px;margin-bottom:24px;">
				<h4 style="font-size:1rem;font-weight:700;color:#92400E;margin:0 0 12px;">Bank Transfer Details</h4>
				<div style="font-size:0.9375rem;color:#78350F;line-height:2;">
					Account Name: <strong>Daan Foundation</strong><br>
					Bank: <strong>State Bank of India</strong><br>
					A/C No: <strong>42818355421</strong><br>
					IFSC: <strong>SBIN0003448</strong><br>
					Branch: Amroha, Uttar Pradesh
				</div>
				<p style="font-size:0.8125rem;color:#92400E;margin:12px 0 0;">After transferring, please keep the transaction reference for your records.</p>
			</div>

			<div id="payment-upi-details" style="display:none;text-align:center;margin-bottom:24px;">
				<h4 style="font-size:1.125rem;font-weight:700;color:#111827;margin:0 0 16px;">Scan to Pay via UPI</h4>
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/payment-qr.jpeg' ); ?>" alt="UPI QR Code" width="200" height="200" loading="lazy" style="width:200px;height:200px;border:2px solid #E2E8F0;border-radius:12px;padding:8px;margin:0 auto;display:block;" onerror="this.style.display='none'">
				<p style="font-size:0.9375rem;color:#64748B;margin:12px 0 0;">UPI ID: <strong>8899152910@ptsbi</strong></p>
				<p style="font-size:0.8125rem;color:#64748B;">Scan with GPay / PhonePe / PayTM</p>
			</div>

			<button type="button" id="confirm-btn" onclick="confirmDonation()" style="width:100%;border-radius:12px;background:#F97316;color:#fff;padding:16px 0;font-size:1.125rem;font-weight:700;border:none;cursor:pointer;box-shadow:0 4px 6px -1px rgba(249,115,22,0.3);transition:background 0.2s;margin-bottom:16px;">
				Confirm Donation
			</button>

			<div id="donation-processing" style="display:none;text-align:center;padding:16px;background:#F0F9FF;border:1px solid #BAE6FD;border-radius:12px;margin-bottom:24px;">
				<p style="font-size:0.9375rem;color:#0369A1;margin:0;">Creating your donation order...</p>
			</div>

			<div style="background:#F0F9FF;border:1px solid #BAE6FD;border-radius:12px;padding:12px 16px;margin-bottom:24px;">
				<p style="font-size:0.8125rem;color:#0369A1;margin:0;text-align:center;">&#x1f512; 256-bit encryption &mdash; your information is secure</p>
			</div>

			<button type="button" onclick="goToStep(2)" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;background:#fff;color:#475569;padding:14px 0;font-size:1rem;font-weight:600;cursor:pointer;transition:border-color 0.2s;">Back</button>
		</div>
	</div>

</div>

<script>
(function() {
	var currentStep = 1;
	var givingType = 'one-time';

	window.setGivingType = function(type) {
		givingType = type;
		var ot = document.getElementById('giving-onetime');
		var mo = document.getElementById('giving-monthly');
		if (type === 'one-time') {
			ot.style.borderColor = '#F97316'; ot.style.background = '#FFF7ED'; ot.style.color = '#EA580C'; ot.style.fontWeight = '700';
			mo.style.borderColor = '#E2E8F0'; mo.style.background = '#fff'; mo.style.color = '#64748B'; mo.style.fontWeight = '600';
		} else {
			mo.style.borderColor = '#F97316'; mo.style.background = '#FFF7ED'; mo.style.color = '#EA580C'; mo.style.fontWeight = '700';
			ot.style.borderColor = '#E2E8F0'; ot.style.background = '#fff'; ot.style.color = '#64748B'; ot.style.fontWeight = '600';
		}
		document.getElementById('summary-frequency').textContent = type === 'one-time' ? 'One-Time' : 'Monthly';
	};

	// Pre-select from URL params or defaults
	var selectedAmount = <?php echo $preset_amount; ?>;
	var causeText = '<?php echo esc_js($preset_cause); ?>';

	window.selectDonateAmount = function(btn, amt) {
		document.querySelectorAll('.donate-amount-btn').forEach(function(b) {
			b.style.borderColor = '#E2E8F0'; b.style.background = '#fff'; b.style.color = '#334155';
		});
		btn.style.borderColor = '#F97316'; btn.style.background = '#FFF7ED'; btn.style.color = '#EA580C';
		selectedAmount = amt;
		document.getElementById('custom-donate-amount').value = '';
		document.getElementById('step1-amount-display').textContent = '\u20b9' + amt.toLocaleString('en-IN');
		document.getElementById('summary-amount').textContent = '\u20b9' + amt.toLocaleString('en-IN');
	};

	window.customDonateAmount = function(input) {
		document.querySelectorAll('.donate-amount-btn').forEach(function(b) {
			b.style.borderColor = '#E2E8F0'; b.style.background = '#fff'; b.style.color = '#334155';
		});
		var val = parseInt(input.value) || 0;
		selectedAmount = val;
		document.getElementById('step1-amount-display').textContent = '\u20b9' + (val > 0 ? val.toLocaleString('en-IN') : '0');
		document.getElementById('summary-amount').textContent = '\u20b9' + (val > 0 ? val.toLocaleString('en-IN') : '0');
	};

	window.selectCause = function(radio) {
		causeText = radio.value;
		document.querySelectorAll('input[name="cause"]').forEach(function(r) {
			r.closest('label').style.background = '#fff';
			r.closest('label').style.borderColor = '#E2E8F0';
		});
		radio.closest('label').style.background = '#FFF7ED';
		radio.closest('label').style.borderColor = '#F97316';
		document.getElementById('summary-cause').textContent = causeText;
	};

	window.goToStep = function(step) {
		[1,2,3].forEach(function(s) {
			var el = document.getElementById('step-' + s);
			if (el) el.style.display = s === step ? 'block' : 'none';
		});
		[1,2,3].forEach(function(s) {
			var circle = document.getElementById('step-circle-' + s);
			var line = document.getElementById('step-line-' + s);
			if (circle) {
				circle.style.background = s <= step ? '#F97316' : '#E5E7EB';
				circle.style.color = s <= step ? '#fff' : '#94A3B8';
			}
			if (line) line.style.background = s < step ? '#F97316' : '#E5E7EB';
		});
		currentStep = step;
	};

	window.validateAndGoToStep3 = function() {
		var first = document.getElementById('donor-firstname').value.trim();
		var last = document.getElementById('donor-lastname').value.trim();
		var email = document.getElementById('donor-email').value.trim();
		var city = document.getElementById('donor-city').value.trim();
		var state = document.getElementById('donor-state').value;
		var pincode = document.getElementById('donor-pincode').value.trim();
		if (!first || !last) { alert('Please enter your full name.'); return; }
		if (!email || !email.includes('@')) { alert('Please enter a valid email address.'); return; }
		if (!city) { alert('Please enter your city.'); return; }
		if (!state) { alert('Please select your state.'); return; }
		if (!pincode || pincode.length !== 6 || !/^\d+$/.test(pincode)) { alert('Please enter a valid 6-digit pincode.'); return; }
		goToStep(3);
	};

	window.selectPaymentMethod = function(radio) {
		var isBacs = radio.value === 'bacs';
		document.getElementById('payment-bacs-label').style.borderColor = isBacs ? '#F97316' : '#E2E8F0';
		document.getElementById('payment-bacs-label').style.background = isBacs ? '#FFF7ED' : '#fff';
		document.getElementById('payment-upi-label').style.borderColor = isBacs ? '#E2E8F0' : '#F97316';
		document.getElementById('payment-upi-label').style.background = isBacs ? '#fff' : '#FFF7ED';
		document.getElementById('payment-bacs-details').style.display = isBacs ? 'block' : 'none';
		document.getElementById('payment-upi-details').style.display = isBacs ? 'none' : 'block';
	};

	window.confirmDonation = function() {
		var first = document.getElementById('donor-firstname').value.trim();
		var last = document.getElementById('donor-lastname').value.trim();
		var email = document.getElementById('donor-email').value.trim();
		var phone = document.getElementById('donor-phone').value.trim();
		var city = document.getElementById('donor-city').value.trim();
		var state = document.getElementById('donor-state').value;
		var pincode = document.getElementById('donor-pincode').value.trim();
		var paymentMethod = document.querySelector('input[name="payment_method"]:checked');

		if (selectedAmount < 1) { alert('Please select a valid donation amount.'); return; }
		if (!paymentMethod) { alert('Please select a payment method.'); return; }

		var processing = document.getElementById('donation-processing');
		var btn = document.getElementById('confirm-btn');
		processing.style.display = 'block';
		btn.disabled = true;
		btn.textContent = 'Processing...';

		var formData = new FormData();
		formData.append('action', 'daan_place_order');
		formData.append('amount', selectedAmount);
		formData.append('cause', causeText);
		formData.append('first_name', first);
		formData.append('last_name', last);
		formData.append('email', email);
		formData.append('phone', phone);
		formData.append('city', city);
		formData.append('state', state);
		formData.append('pincode', pincode);
		formData.append('frequency', givingType);
		formData.append('payment_method', paymentMethod.value);

		fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
			method: 'POST',
			body: formData
		})
		.then(function(r) { return r.json(); })
		.then(function(data) {
			if (data.success && data.data && data.data.redirect_url) {
				window.location.href = data.data.redirect_url;
			} else {
				alert(data.data && data.data.message ? data.data.message : 'Failed to place donation. Please try again.');
				processing.style.display = 'none';
				btn.disabled = false;
				btn.textContent = 'Confirm Donation';
			}
		})
		.catch(function(err) {
			alert('An error occurred. Please try again later.');
			processing.style.display = 'none';
			btn.disabled = false;
			btn.textContent = 'Confirm Donation';
		});
	};

	// Pre-select amount from URL param or default
	var defaultBtn = document.querySelector('.donate-amount-btn[data-amount="<?php echo $preset_amount; ?>"]');
	if (defaultBtn) {
		selectDonateAmount(defaultBtn, <?php echo $preset_amount; ?>);
	} else {
		document.getElementById('custom-donate-amount').value = <?php echo $preset_amount; ?>;
		customDonateAmount(document.getElementById('custom-donate-amount'));
	}
	// Pre-select cause from URL param
	var causeRadio = document.querySelector('input[name="cause"][value="<?php echo esc_js($preset_cause); ?>"]');
	if (causeRadio) selectCause(causeRadio);
})();
</script>

<?php
get_footer();
