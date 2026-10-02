param(
    [string]$Site = 'https://daanfoundation.in/',
    [int]$TimeoutSeconds = 5
)

$ErrorActionPreference = 'Stop'
[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12
$root = Split-Path -Parent $PSScriptRoot
$reportDir = Join-Path $root 'reports'
$utc = [DateTime]::UtcNow.ToString('o')
$siteUri = [Uri]$Site
Add-Type -AssemblyName System.Web.Extensions
$serializer = New-Object System.Web.Script.Serialization.JavaScriptSerializer
$serializer.MaxJsonLength = 16777216

function Get-PublicResponse([string]$Url, [bool]$Follow = $true) {
    $chain = New-Object System.Collections.Generic.List[string]
    $current = $Url
    for($hop = 0; $hop -lt 10; $hop++) {
        $request = [Net.HttpWebRequest]::Create($current)
        $request.Method = 'GET'; $request.AllowAutoRedirect = $false; $request.Timeout = $TimeoutSeconds * 1000
        $request.ReadWriteTimeout = $TimeoutSeconds * 1000; $request.UserAgent = 'DaanFoundation-BatchA-ReadOnly/1.0'
        try { $response = [Net.HttpWebResponse]$request.GetResponse() } catch [Net.WebException] { $response = $_.Exception.Response }
        if($null -eq $response) { return [pscustomobject]@{Error=$_.Exception.Message; Chain=($chain -join ' -> '); FinalUrl=$current; Status=$null; ContentType=''; Headers=@{}; Body=''} }
        $status = [int]$response.StatusCode; $headers = @{}; foreach($key in $response.Headers.AllKeys) { $headers[$key] = $response.Headers[$key] }
        $chain.Add("$status $current")
        $location = $response.Headers['Location']
        if($Follow -and $status -ge 300 -and $status -lt 400 -and $location -and $hop -lt 9) { $response.Close(); $current = ([Uri]::new([Uri]$current, $location)).AbsoluteUri; continue }
        $reader = New-Object IO.StreamReader($response.GetResponseStream())
        $body = $reader.ReadToEnd(); $reader.Close(); $response.Close()
        return [pscustomobject]@{Error=''; Chain=($chain -join ' -> '); FinalUrl=$current; Status=$status; ContentType=$headers['Content-Type']; Headers=$headers; Body=$body}
    }
    return [pscustomobject]@{Error='Redirect limit'; Chain=($chain -join ' -> '); FinalUrl=$current; Status=$null; ContentType=''; Headers=@{}; Body=''}
}

function HtmlText([string]$text) { $clean = [regex]::Replace($text, '<[^>]+>', ' '); $decoded = [Net.WebUtility]::HtmlDecode($clean); return (($decoded.Trim()) -replace '\s+', ' ') }
function MatchOne([string]$body, [string]$pattern) { $m=[regex]::Match($body,$pattern,[Text.RegularExpressions.RegexOptions]::IgnoreCase -bor [Text.RegularExpressions.RegexOptions]::Singleline); if($m.Success){return [Net.WebUtility]::HtmlDecode($m.Groups[1].Value.Trim())}; return '' }
function IsActionUrl([string]$u) { return $u -match '(?i)(logout|add-to-cart|woocommerce|wc-ajax|payment|pay_for_order|wp-login|lost-password|reset-password|\bnonce=|\baction=)' }

# Discover sitemap endpoints from robots, then the sitemap index.
$robots = Get-PublicResponse ([Uri]::new($siteUri,'/robots.txt')).AbsoluteUri
$sitemapUrls = @([regex]::Matches($robots.Body, '(?im)^\s*Sitemap:\s*(\S+)') | ForEach-Object {$_.Groups[1].Value})
if(!$sitemapUrls) { $sitemapUrls = @(([Uri]::new($siteUri,'/sitemap_index.xml')).AbsoluteUri) }
$childSitemaps = New-Object System.Collections.Generic.List[string]
foreach($s in $sitemapUrls) {
    $r=Get-PublicResponse $s
    foreach($m in [regex]::Matches($r.Body,'<sitemap>.*?<loc>(.*?)</loc>.*?</sitemap>',[Text.RegularExpressions.RegexOptions]::Singleline)) { $childSitemaps.Add([Net.WebUtility]::HtmlDecode($m.Groups[1].Value.Trim())) }
    if(!$childSitemaps.Count -and $r.Body -match '<urlset') { $childSitemaps.Add($r.FinalUrl) }
}
$urlSources = @{}
foreach($s in $childSitemaps | Select-Object -Unique) {
    $r=Get-PublicResponse $s
    foreach($m in [regex]::Matches($r.Body,'<url>.*?<loc>(.*?)</loc>.*?</url>',[Text.RegularExpressions.RegexOptions]::Singleline)) {
        $u=[Net.WebUtility]::HtmlDecode($m.Groups[1].Value.Trim()); if(!$urlSources.ContainsKey($u)){$urlSources[$u]=New-Object System.Collections.Generic.List[string]}; $urlSources[$u].Add($s)
    }
}

$rows=New-Object System.Collections.Generic.List[object]; $links=New-Object System.Collections.Generic.List[object]; $schema=New-Object System.Collections.Generic.List[object]
foreach($requested in ($urlSources.Keys | Sort-Object)) {
    $r=Get-PublicResponse $requested
    $body=$r.Body; $isHtml=$r.ContentType -match '(?i)text/html|application/xhtml'
    $title=if($isHtml){MatchOne $body '<title[^>]*>(.*?)</title>'}else{''}; $desc=if($isHtml){MatchOne $body '<meta[^>]+name\s*=\s*["'']description["''][^>]+content\s*=\s*["''](.*?)["'']'}else{''}
    if(!$desc -and $isHtml){$desc=MatchOne $body '<meta[^>]+content\s*=\s*["''](.*?)["''][^>]+name\s*=\s*["'']description["'']'}
    $canonMatches=if($isHtml){[regex]::Matches($body,'<link[^>]+rel\s*=\s*["''][^"'']*canonical[^"'']*["''][^>]+href\s*=\s*["''](.*?)["'']',[Text.RegularExpressions.RegexOptions]::IgnoreCase)}else{@()}
    $canon=if($canonMatches.Count){[Net.WebUtility]::HtmlDecode($canonMatches[0].Groups[1].Value)}else{''}; $canonResolved=if($canon){try{([Uri]::new([Uri]$r.FinalUrl,$canon)).AbsoluteUri}catch{''}}else{''}
    $h1=if($isHtml){[regex]::Matches($body,'<h1\b[^>]*>(.*?)</h1>',[Text.RegularExpressions.RegexOptions]::IgnoreCase -bor [Text.RegularExpressions.RegexOptions]::Singleline)}else{@()}; $h1Text=($h1 | ForEach-Object {HtmlText ($_.Groups[1].Value)}) -join ' | '
    $metaRobots=if($isHtml){MatchOne $body '<meta[^>]+name\s*=\s*["'']robots["''][^>]+content\s*=\s*["''](.*?)["'']'}else{''}; if(!$metaRobots -and $isHtml){$metaRobots=MatchOne $body '<meta[^>]+content\s*=\s*["''](.*?)["''][^>]+name\s*=\s*["'']robots["'']'}
    $xRobots=$r.Headers['X-Robots-Tag']; $indexability=if($metaRobots -match '(?i)noindex' -or $xRobots -match '(?i)noindex'){'noindex observed'}else{'no noindex observed in raw response'}
    $jsonScripts=if($isHtml){[regex]::Matches($body,'<script[^>]+type\s*=\s*["'']application/ld\+json["''][^>]*>(.*?)</script>',[Text.RegularExpressions.RegexOptions]::IgnoreCase -bor [Text.RegularExpressions.RegexOptions]::Singleline)}else{@()}
    $types=New-Object System.Collections.Generic.List[string]; $ids=New-Object System.Collections.Generic.List[string]; $errors=New-Object System.Collections.Generic.List[string]
    foreach($js in $jsonScripts){$raw=$js.Groups[1].Value.Trim(); try{$null=$serializer.DeserializeObject($raw); foreach($tm in [regex]::Matches($raw,'"@type"\s*:\s*(\[[^\]]*\]|"[^"]+")')){$types.Add(($tm.Groups[1].Value -replace '[\[\]"]','' -replace '\s+',''))}; foreach($im in [regex]::Matches($raw,'"@id"\s*:\s*"([^"]+)"')){$ids.Add($im.Groups[1].Value)}}catch{$errors.Add($_.Exception.Message)}}
    $rows.Add([pscustomobject]@{utc_check_time=$utc;requested_url=$requested;redirect_chain=$r.Chain;final_url=$r.FinalUrl;http_status=$r.Status;content_type=$r.ContentType;fetch_result=if($r.Error){"ERROR: $($r.Error)"}else{'OK'};title=$title;title_count=$title.Length;meta_description=$desc;meta_description_count=$desc.Length;h1_count=$h1.Count;h1_text=$h1Text;canonical_count=$canonMatches.Count;canonical_value=$canon;canonical_resolved_url=$canonResolved;meta_robots=$metaRobots;x_robots_tag=$xRobots;sitemap_sources=($urlSources[$requested] -join ' | ');source_indexability_observation=$indexability;jsonld_script_count=$jsonScripts.Count;jsonld_types=($types|Select-Object -Unique)-join ' | ';jsonld_entity_ids=($ids|Select-Object -Unique)-join ' | ';jsonld_parsing_errors=($errors -join ' | ');observation_basis='raw HTTP response/source; not browser-rendered'})
    $schema.Add([pscustomobject]@{url=$requested;final_url=$r.FinalUrl;status=$r.Status;scripts=$jsonScripts.Count;types=(($types|Select-Object -Unique)-join ' | ');entity_ids=(($ids|Select-Object -Unique)-join ' | ');parse_errors=($errors -join ' | ')})
    if($isHtml) { foreach($m in [regex]::Matches($body,'<a\b([^>]*)href\s*=\s*["'']([^"'']+)["''][^>]*>(.*?)</a>',[Text.RegularExpressions.RegexOptions]::IgnoreCase -bor [Text.RegularExpressions.RegexOptions]::Singleline)) { $href=[Net.WebUtility]::HtmlDecode($m.Groups[2].Value.Trim()); if(!$href -or $href -match '^(#|mailto:|tel:|javascript:)'){continue}; try{$dest=([Uri]::new([Uri]$r.FinalUrl,$href)).AbsoluteUri}catch{continue}; $du=[Uri]$dest; if($du.Host -ne $siteUri.Host){continue}; if(IsActionUrl $dest){continue}; $rel=MatchOne $m.Value 'rel\s*=\s*["''](.*?)["'']'; $links.Add([pscustomobject]@{utc_check_time=$utc;source_url=$r.FinalUrl;destination_url=$dest;anchor_text=(HtmlText ($m.Groups[3].Value));rel=$rel;destination_redirect_chain='';destination_final_url='';destination_http_status='';destination_fetch_result='';follow_check='pending'}) } }
}
$uniqueDest=$links.destination_url|Sort-Object -Unique; $destStatus=@{}; foreach($d in $uniqueDest){$r=Get-PublicResponse $d; $destStatus[$d]=[pscustomobject]@{status=$r.Status;final=$r.FinalUrl;chain=$r.Chain;error=$r.Error}}
foreach($l in $links){$v=$destStatus[$l.destination_url]; $l.destination_redirect_chain=$v.chain; $l.destination_final_url=$v.final; $l.destination_http_status=$v.status; $l.destination_fetch_result=if($v.error){"ERROR: $($v.error)"}else{'OK'}; $l.follow_check=if($v.error){"ERROR: $($v.error)"}elseif($v.status -ge 400){"BROKEN $($v.status)"}elseif($v.chain -match ' -> '){"REDIRECT $($v.status) => $($v.final)"}else{"OK $($v.status)"}}
$rows | Export-Csv (Join-Path $reportDir 'current-url-field-inventory.csv') -NoTypeInformation -Encoding UTF8
$links | Export-Csv (Join-Path $reportDir 'current-internal-link-inventory.csv') -NoTypeInformation -Encoding UTF8
$bad=$links|Where-Object{$_.follow_check -match '^(BROKEN|ERROR|REDIRECT)'}; $redirectLinks=$links|Where-Object{$_.follow_check -match '^REDIRECT'}; $redirectDestinations=$redirectLinks.destination_final_url|Sort-Object -Unique; $orphans=$rows|Where-Object{$links.destination_final_url -notcontains $_.final_url}
$schemaRows=$schema|Where-Object{$_.scripts -gt 0}; $schemaErrors=$schema|Where-Object{$_.parse_errors}
@"
# Current schema evidence — Batch A

**UTC check time:** $utc  
**Method:** raw public HTTP response/source collection by `scripts/crawl-batch-a.ps1`; no browser renderer, Rich Results Test, or external schema validator was available.

## Coverage

- Sitemap URLs checked: $($rows.Count)
- URLs with JSON-LD source: $($schemaRows.Count)
- URLs with JSON-LD parsing errors: $($schemaErrors.Count)
- Representative raw-source coverage: homepage, static/program pages, FAQ, article, and product are included when present in the discovered sitemap inventory.

## Scope limits

This is source-level evidence. It does not validate browser-rendered/injected schema, eligibility for Google rich results, or indexation. Entity types and IDs are exported in `current-url-field-inventory.csv`.

## Parsing anomalies

$(if($schemaErrors){($schemaErrors|ForEach-Object{"- $($_.url): $($_.parse_errors)"}) -join "`n"}else{'- None observed in collected JSON-LD scripts.'})
"@ | Set-Content (Join-Path $reportDir 'current-schema-evidence.md') -Encoding UTF8
@"
# Batch A current crawl results

**UTC check time:** $utc  
**Method:** read-only public HTTP/source crawl. Raw source was collected; no browser-rendered, GSC, backlink, origin, CDN-control-plane, or payment-flow validation was performed.

## Discovery and coverage

- Robots sitemap declarations discovered: $($sitemapUrls -join ', ')
- Child sitemaps discovered: $($childSitemaps.Count)
- Sitemap URLs discovered and checked: $($rows.Count)
- Successful fetches: $(($rows|Where-Object{$_.fetch_result -eq 'OK'}).Count)
- Non-200 final statuses: $(($rows|Where-Object{$_.http_status -ne 200}).Count)
- Internal link occurrences recorded: $($links.Count)
- Unique relevant internal destinations checked: $($uniqueDest.Count)
- Broken/error internal destinations: $(($bad|Where-Object{$_.follow_check -match '^(BROKEN|ERROR)'}).Count)
- Redirecting internal-link occurrences: $($redirectLinks.Count)
- Unique redirect final destinations: $($redirectDestinations.Count)
- Potential orphans within crawl scope: $($orphans.Count)

## Deliverables

- `reports/current-url-field-inventory.csv` — raw-source URL fields and schema observations.
- `reports/current-internal-link-inventory.csv` — internal links excluding action URLs; destination outcomes included.
- `reports/current-schema-evidence.md` — source-level JSON-LD parsing scope and anomalies.

## Status

- **TECH-01:** completed for raw-source field collection; browser-rendered/validator coverage remains **INCONCLUSIVE**.
- **TECH-04:** completed for links extracted from crawled HTML; potential orphans are scope-limited, not site-wide confirmed.
- **TECH-05:** source-level JSON-LD parsing completed; external/browser schema validation remains **INCONCLUSIVE**.
- **DATA-01 / DATA-02 / DATA-03:** **BLOCKED** — no GSC export, backlink export, or authoritative historic route inventory was supplied. These IDs are defined in `reports/master-seo-remediation-tracker.md`; they are not crawl defects.

## Findings requiring review

$(if($redirectLinks){"- CONFIRMED DEFECT TECH-07: $($redirectLinks.Count) internal-link occurrences point to non-canonical URLs that redirect, across $($redirectDestinations.Count) final destinations. Exact evidence is in current-internal-link-inventory.csv."}else{'- No redirecting relevant internal links observed in this crawl.'})
$(if($bad|Where-Object{$_.follow_check -match '^(BROKEN|ERROR)'}){($bad|Where-Object{$_.follow_check -match '^(BROKEN|ERROR)'}|Select-Object -First 50|ForEach-Object{"- $($_.follow_check): $($_.source_url) -> $($_.destination_url)"}) -join "`n"}else{'- No broken or error internal destinations observed in this crawl.'})

## Limitations

Missing raw-source metadata is an observation, not proof of a rendered defect. No claim is made about Google indexing, ranking, content quality, browser DOM, accessibility, Core Web Vitals, or current production origin/CDN parity.
"@ | Set-Content (Join-Path $reportDir 'batch-a-current-crawl-results.md') -Encoding UTF8
Write-Output "SITEMAP_URLS=$($rows.Count) LINKS=$($links.Count) UNIQUE_DESTINATIONS=$($uniqueDest.Count) BAD_LINKS=$($bad.Count)"
