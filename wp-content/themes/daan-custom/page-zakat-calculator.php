<?php
/**
 * Template Name: Zakat Calculator
 *
 * Zakat Calculator page — interactive calculator form with JavaScript logic.
 */
get_header();
?>

<!-- Breadcrumbs -->
<div style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;">
	<div style="max-width:1280px;margin:0 auto;padding:12px 16px;">
		<nav style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#64748B;">
			<a href="/" style="color:#64748B;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#EA580C'" onmouseout="this.style.color='#64748B'">Home</a>
			<span>/</span>
			<a href="/zakat" style="color:#64748B;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#EA580C'" onmouseout="this.style.color='#64748B'">Zakat</a>
			<span>/</span>
			<span style="color:#111827;font-weight:600;">Calculator</span>
		</nav>
	</div>
</div>

<!-- Hero -->
<section style="background:linear-gradient(135deg,#EA580C,#F97316);padding:48px 16px;text-align:center;">
	<div style="max-width:768px;margin:0 auto;">
		<h1 style="font-size:2.25rem;font-weight:800;color:#fff;line-height:1.1;margin:0 0 16px;">Zakat Calculator</h1>
		<p style="font-size:1.125rem;color:rgba(255,255,255,0.9);margin:0;">Calculate your Zakat accurately</p>
	</div>
</section>

<!-- Calculator -->
<div style="max-width:768px;margin:0 auto;padding:48px 16px;">
	<div style="background:#fff;border-radius:16px;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);padding:32px;">
		<h3 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 24px;">Your Wealth</h3>

		<div style="display:flex;flex-direction:column;gap:16px;margin-bottom:32px;">
			<div>
				<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Cash & Bank Balance (₹)</label>
				<input type="number" id="zakat-cash" value="0" min="0" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;background:#fff;transition:border-color 0.2s;">
			</div>
			<div>
				<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Gold (grams)</label>
				<input type="number" id="zakat-gold" value="0" min="0" step="0.01" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;background:#fff;transition:border-color 0.2s;">
			</div>
			<div>
				<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Silver (grams)</label>
				<input type="number" id="zakat-silver" value="0" min="0" step="0.01" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;background:#fff;transition:border-color 0.2s;">
			</div>
			<div>
				<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Business Assets (₹)</label>
				<input type="number" id="zakat-business" value="0" min="0" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;background:#fff;transition:border-color 0.2s;">
			</div>
			<div>
				<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Savings & Investments (₹)</label>
				<input type="number" id="zakat-savings" value="0" min="0" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;background:#fff;transition:border-color 0.2s;">
			</div>
			<div>
				<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Other Assets (₹)</label>
				<input type="number" id="zakat-other" value="0" min="0" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;background:#fff;transition:border-color 0.2s;">
			</div>
		</div>

		<h3 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 24px;">Liabilities</h3>

		<div style="display:flex;flex-direction:column;gap:16px;margin-bottom:32px;">
			<div>
				<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Outstanding Debts (₹)</label>
				<input type="number" id="zakat-debts" value="0" min="0" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;background:#fff;transition:border-color 0.2s;">
			</div>
			<div>
				<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Loans (₹)</label>
				<input type="number" id="zakat-loans" value="0" min="0" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;background:#fff;transition:border-color 0.2s;">
			</div>
			<div>
				<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Other Deductions (₹)</label>
				<input type="number" id="zakat-deductions" value="0" min="0" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;background:#fff;transition:border-color 0.2s;">
			</div>
		</div>

		<button onclick="calculateZakat()" style="width:100%;border-radius:12px;background:#F97316;color:#fff;padding:16px 0;font-size:1.125rem;font-weight:700;border:none;cursor:pointer;box-shadow:0 4px 6px -1px rgba(249,115,22,0.3);transition:background 0.2s;" onmouseover="this.style.background='#EA580C'" onmouseout="this.style.background='#F97316'">Calculate</button>

		<!-- Results -->
		<div id="zakat-results" style="display:none;margin-top:32px;background:#F8FAFC;border-radius:16px;padding:24px;">
			<h3 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 16px;">Your Zakat Summary</h3>
			<div style="display:flex;flex-direction:column;gap:12px;">
				<div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #E2E8F0;">
					<span style="font-size:0.9375rem;color:#64748B;">Total Assets</span>
					<span id="zakat-total-assets" style="font-size:1rem;font-weight:700;color:#111827;">₹0</span>
				</div>
				<div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #E2E8F0;">
					<span style="font-size:0.9375rem;color:#64748B;">Total Deductions</span>
					<span id="zakat-total-deductions" style="font-size:1rem;font-weight:700;color:#111827;">₹0</span>
				</div>
				<div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #E2E8F0;">
					<span style="font-size:0.9375rem;color:#64748B;">Zakatable Wealth</span>
					<span id="zakat-wealth" style="font-size:1rem;font-weight:700;color:#111827;">₹0</span>
				</div>
				<div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #E2E8F0;">
					<span style="font-size:0.9375rem;color:#64748B;">Nisab Threshold (Silver)</span>
					<span id="zakat-nisab" style="font-size:1rem;font-weight:700;color:#111827;">~₹45,000</span>
				</div>
				<div id="zakat-due-row" style="display:flex;justify-content:space-between;padding:8px 0;">
					<span style="font-size:0.9375rem;color:#64748B;">Zakat Due (2.5%)</span>
					<span id="zakat-due" style="font-size:1.125rem;font-weight:800;color:#EA580C;">₹0</span>
				</div>
				<div id="zakat-no-due" style="display:none;background:#ECFDF5;border-radius:12px;padding:16px;text-align:center;">
					<p style="font-size:1rem;font-weight:600;color:#065F46;margin:0;">No Zakat Due — Your wealth is below the Nisab threshold.</p>
				</div>
			</div>
		</div>
	</div>

	<p style="font-size:0.875rem;color:#64748B;margin:24px 0 32px;text-align:center;">Note: This calculator is a guide. Please consult a scholar for complex cases.</p>

	<div style="text-align:center;">
		<a href="/donate" style="display:inline-flex;align-items:center;gap:8px;border-radius:9999px;background:#F97316;padding:16px 32px;font-weight:700;color:#fff;text-decoration:none;box-shadow:0 20px 25px -5px rgba(249,115,22,0.3);transition:background 0.2s;"
		   onmouseover="this.style.background='#EA580C'" onmouseout="this.style.background='#F97316'">Pay Your Zakat →</a>
	</div>
</div>

<script>
function calculateZakat() {
	var cash = parseFloat(document.getElementById('zakat-cash').value) || 0;
	var gold = parseFloat(document.getElementById('zakat-gold').value) || 0;
	var silver = parseFloat(document.getElementById('zakat-silver').value) || 0;
	var business = parseFloat(document.getElementById('zakat-business').value) || 0;
	var savings = parseFloat(document.getElementById('zakat-savings').value) || 0;
	var other = parseFloat(document.getElementById('zakat-other').value) || 0;
	var debts = parseFloat(document.getElementById('zakat-debts').value) || 0;
	var loans = parseFloat(document.getElementById('zakat-loans').value) || 0;
	var deductions = parseFloat(document.getElementById('zakat-deductions').value) || 0;

	var goldPricePerGram = 6500;
	var silverPricePerGram = 85;

	var goldValue = gold * goldPricePerGram;
	var silverValue = silver * silverPricePerGram;

	var totalAssets = cash + goldValue + silverValue + business + savings + other;
	var totalLiabilities = debts + loans + deductions;
	var zakatableWealth = totalAssets - totalLiabilities;

	var nisabSilver = 612 * silverPricePerGram;

	document.getElementById('zakat-total-assets').textContent = '₹' + totalAssets.toLocaleString('en-IN');
	document.getElementById('zakat-total-deductions').textContent = '₹' + totalLiabilities.toLocaleString('en-IN');
	document.getElementById('zakat-wealth').textContent = '₹' + zakatableWealth.toLocaleString('en-IN');
	document.getElementById('zakat-nisab').textContent = '~₹' + nisabSilver.toLocaleString('en-IN');

	var resultsDiv = document.getElementById('zakat-results');
	resultsDiv.style.display = 'block';

	var dueRow = document.getElementById('zakat-due-row');
	var noDue = document.getElementById('zakat-no-due');

	if (zakatableWealth >= nisabSilver) {
		var zakatDue = zakatableWealth * 0.025;
		document.getElementById('zakat-due').textContent = '₹' + zakatDue.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
		dueRow.style.display = 'flex';
		noDue.style.display = 'none';
	} else {
		dueRow.style.display = 'none';
		noDue.style.display = 'block';
	}
}
</script>

<?php
get_footer();
