<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Design Previews · {{ config('app.name') }}</title>
    @vite(['resources/css/auth-login-v1.css'])
    <style>
        body.auth-demo-index { min-height:100vh; margin:0; padding:48px 22px; color:#1b2b25; background:#f3f6f4; font-family:Inter,system-ui,sans-serif; }
        .auth-demo-shell { width:min(1060px,100%); margin:0 auto; }
        .auth-demo-heading { margin-bottom:30px; }
        .auth-demo-heading .eyebrow { display:inline-flex; padding:6px 10px; border-radius:999px; color:#176344; background:#e2f2e9; font-size:12px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; }
        .auth-demo-heading h1 { margin:14px 0 8px; font-size:clamp(28px,4vw,40px); font-weight:800; letter-spacing:-.04em; }
        .auth-demo-heading p { max-width:660px; margin:0; color:#66756d; line-height:1.65; }
        .auth-demo-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:18px; }
        .auth-demo-card { display:flex; flex-direction:column; min-height:210px; padding:24px; border:1px solid #e2e9e5; border-radius:18px; background:#fff; box-shadow:0 12px 32px -24px rgba(21,53,38,.24); }
        .auth-demo-card .number { color:#84948b; font-size:12px; font-weight:800; letter-spacing:.12em; }
        .auth-demo-card h2 { margin:12px 0 8px; font-size:21px; font-weight:750; }
        .auth-demo-card p { flex:1; margin:0 0 20px; color:#68776f; line-height:1.6; font-size:14px; }
        .auth-demo-card a { display:inline-flex; align-items:center; justify-content:center; align-self:flex-start; padding:10px 15px; border-radius:10px; color:#fff; background:#176344; text-decoration:none; font-size:14px; font-weight:700; transition:transform .15s,background .15s; }
        .auth-demo-card a:hover { color:#fff; background:#104c33; transform:translateY(-1px); }
        .auth-demo-note { margin-top:22px; padding:14px 16px; border:1px solid #e6e9e7; border-radius:12px; color:#65736c; background:#fff; font-size:13px; line-height:1.6; }
        @media(max-width:680px){ .auth-demo-grid{grid-template-columns:1fr;} body.auth-demo-index{padding:28px 16px;} }
    </style>
</head>
<body class="auth-demo-index">
    <main class="auth-demo-shell">
        <header class="auth-demo-heading">
            <span class="eyebrow">Reusable Admin UI · Auth</span>
            <h1>Login design previews</h1>
            <p>चारों Login variants को अलग-अलग preview करें। ये केवल visual demos हैं; कोई वास्तविक authentication या credential submission नहीं होता।</p>
        </header>

        <section class="auth-demo-grid" aria-label="Login design variants">
            <article class="auth-demo-card">
                <span class="number">LOGIN · 01</span>
                <h2>WhatsApp CRM</h2>
                <p>Original dark split-screen design with WhatsApp green accents, feature highlights and social login area.</p>
                <a href="{{ route('admin-ui.auth.login-v1') }}">Preview Login V1 <span aria-hidden="true">&nbsp;→</span></a>
            </article>
            <article class="auth-demo-card">
                <span class="number">LOGIN · 02</span>
                <h2>News Portal</h2>
                <p>Editorial newsroom look with the News Networks India logo, supplied background image and warm red-orange accents.</p>
                <a href="{{ route('admin-ui.auth.login-v2') }}">Preview Login V2 <span aria-hidden="true">&nbsp;→</span></a>
            </article>
            <article class="auth-demo-card">
                <span class="number">LOGIN · 03</span>
                <h2>Islamic Education</h2>
                <p>Calm emerald and deep-green theme with subtle geometric texture and antique-gold highlights.</p>
                <a href="{{ route('admin-ui.auth.login-v3') }}">Preview Login V3 <span aria-hidden="true">&nbsp;→</span></a>
            </article>
            <article class="auth-demo-card">
                <span class="number">LOGIN · 04</span>
                <h2>Minimal Centered</h2>
                <p>A simple centered login card with the supplied white logo on a dark brand plate. No marketing panel or social section.</p>
                <a href="{{ route('admin-ui.auth.login-v4') }}">Preview Login V4 <span aria-hidden="true">&nbsp;→</span></a>
            </article>
        </section>

        <article class="auth-demo-card"><span class="number">AUTH · MORE</span><h2>Registration & Forgot Password</h2><p>तीन Registration variants और centered Forgot Password page के demos.</p><a href="{{ route('admin-ui.auth.registration-demos') }}">Open Auth Demos <span aria-hidden="true">&nbsp;→</span></a></article>
        <p class="auth-demo-note"><strong>Preview safety:</strong> Submitting the form only displays a preview-mode toast. No password or email is sent to a server. Social login buttons are also presentation-only unless configured on the real Login route.</p>
    </main>
</body>
</html>
