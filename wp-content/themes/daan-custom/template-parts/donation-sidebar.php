<?php
/**
 * Donation Sidebar Template Part
 *
 * Shown on sidebar-layout pages: About, Community Kitchen, etc.
 */
?>
<aside style="background: #fff; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1); padding: 24px; position: sticky; top: 104px;">
	<h3 style="font-size: 1.25rem; font-weight: 700; color: #111827; text-align: center; margin-bottom: 4px;">Make a Donation</h3>
	<p style="text-align: center; font-size: 0.875rem; color: #64748B; margin-bottom: 20px;">Every contribution makes a difference</p>

	<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 12px;">
		<?php foreach ( array( 500, 1000, 2500, 5000 ) as $amt ) : ?>
			<button onclick="selectAmount(this, <?php echo $amt; ?>)" class="amount-btn <?php echo $amt === 1000 ? 'active' : ''; ?>" style="padding:10px 0;border-radius:12px;font-size:0.875rem;font-weight:700;border:none;cursor:pointer;transition:all 0.2s;background:<?php echo $amt === 1000 ? '#F97316' : '#F1F5F9'; ?>;color:<?php echo $amt === 1000 ? '#fff' : '#334155'; ?>">₹<?php echo $amt; ?></button>
		<?php endforeach; ?>
	</div>

	<div style="position: relative; margin-bottom: 20px;">
		<span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94A3B8; font-weight: 500;">₹</span>
		<input type="number" class="custom-amount" placeholder="Other amount" oninput="clearAmounts(this)" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:10px 12px 10px 28px;font-size:1rem;font-weight:500;color:#111;transition:border-color 0.2s,box-shadow 0.2s;">
	</div>

	<div style="margin-bottom: 20px;">
		<label for="sidebar-cause" style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:8px;">Choose a Cause</label>
		<select id="sidebar-cause" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:10px 12px;font-size:1rem;color:#111;background:#fff;">
			<option>Where Most Needed</option>
			<option>Community Kitchen</option>
			<option>Ramadan Iftar</option>
			<option>Zakat</option>
			<option>Sadaqah</option>
			<option>Fidyah & Kaffarah</option>
		</select>
	</div>

	<button onclick="window.location.href='/donate?amount=' + (document.querySelector('.custom-amount').value || '1000') + '&cause=' + encodeURIComponent(document.getElementById('sidebar-cause').value)" style="width:100%;border-radius:12px;background:#F59E0B;color:#fff;padding:14px 0;font-size:1.125rem;font-weight:700;border:none;cursor:pointer;box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);transition:background 0.2s,box-shadow 0.2s;">Donate Now</button>

	<div style="display:flex;align-items:center;justify-content:center;gap:12px;margin-top:16px;font-size:0.75rem;color:#64748B;">
		<span style="display:flex;align-items:center;gap:4px;">
			<svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
			Secure
		</span>
		<span>•</span>
		<span>Registered Charity</span>
		<span>•</span>
		<span>100% Transparent</span>
	</div>
</aside>
