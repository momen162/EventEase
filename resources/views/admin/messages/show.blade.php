@extends('admin.layout')
@section('title','Message #'.$contact->id)

@section('content')
<div class="admin-message-show"><!-- SCOPE WRAPPER -->
  <style>
    /* Page-scoped tokens (no :root, no global .btn/.table) */
    .admin-message-show{
      --bg:#ffffff;
      --surface:#ffffff;
      --surface-2:#f9fafb;
      --text:#111827;
      --muted:#6b7280;
      --border:#e5e7eb;
      --ring: rgba(37,99,235,.35);

      --primary:#2563eb;
      --primary-600:#1d4ed8;

      --radius:14px;
      --shadow:0 10px 30px rgba(0,0,0,.06);
      --shadow-sm:0 2px 10px rgba(0,0,0,.05);
    }

    .admin-message-show .ms-wrap{ padding: clamp(12px,1.8vw,20px); background:var(--bg); color:var(--text); }

    /* Page head */
    .admin-message-show .ms-head{
      display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; margin-bottom: 12px;
    }
    .admin-message-show .ms-title{ margin:0; font-weight:800; letter-spacing:.2px; }
    .admin-message-show .ms-actions{ display:flex; gap:8px; flex-wrap:wrap; }
    .admin-message-show .ms-btn{
      appearance:none; border:1px solid var(--border); border-radius:999px;
      padding:10px 14px; font-weight:700; cursor:pointer; text-decoration:none;
      background:#fff; color:var(--text); box-shadow:var(--shadow-sm); transition:.18s ease;
      display:inline-flex; align-items:center; gap:.5rem;
    }
    .admin-message-show .ms-btn:hover{ transform: translateY(-1px); box-shadow:var(--shadow); }
    .admin-message-show .ms-btn:focus-visible{ outline:3px solid var(--ring); outline-offset:2px; }
    .admin-message-show .ms-btn-primary{ background:var(--primary); color:#fff; border-color:transparent; }
    .admin-message-show .ms-btn-primary:hover{ background:var(--primary-600); }

    /* Card (re-using your .card element but scoped) */
    .admin-message-show .card{
      background:var(--surface); border:1px solid var(--border); border-radius:var(--radius);
      box-shadow:var(--shadow); padding: clamp(16px,2vw,22px);
    }

    /* Meta grid */
    .admin-message-show .ms-meta{
      display:grid; gap:12px; grid-template-columns: repeat(3, minmax(0,1fr));
      margin-bottom: 12px;
    }
    @media (max-width: 900px){ .admin-message-show .ms-meta{ grid-template-columns:1fr; } }

    .admin-message-show .ms-field{ display:grid; gap:6px; }
    .admin-message-show .ms-label{ font-weight:700; font-size:.95rem; color:var(--muted); }
    .admin-message-show .ms-value{ font-weight:800; }

    .admin-message-show .ms-mail{ color:var(--primary); text-decoration:none; }
    .admin-message-show .ms-mail:hover{ text-decoration:underline; }

    .admin-message-show .ms-chip-date{
      display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:999px;
      background:#ecfeff; color:#155e75; border:1px solid #cffafe; font-weight:700; font-size:.85rem;
    }

    /* Message body */
    .admin-message-show .ms-message{ display:grid; gap:8px; }
    .admin-message-show .pre-wrap{
      white-space:pre-wrap; word-break:break-word; background:var(--surface-2);
      border:1px solid var(--border); border-radius:12px; padding:12px;
      font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
      box-shadow:var(--shadow-sm);
    }
  </style>

  <div class="ms-wrap">
    <div class="ms-head">
      <h1 class="ms-title">Message #{{ $contact->id }}</h1>
      <div class="ms-actions">
        <a class="ms-btn ms-btn-primary"
           href="mailto:{{ $contact->email }}?subject={{ rawurlencode('Re: Your message to us') }}">
          Reply by Email
        </a>
        <button class="ms-btn" type="button" id="copyEmailBtn" data-email="{{ $contact->email }}">
          Copy Email
        </button>
        <a class="ms-btn" href="{{ route('admin.messages.index') }}">Back</a>
      </div>
    </div>

    <div class="card">
      <div class="ms-meta">
        <div class="ms-field">
          <span class="ms-label">Name</span>
          <div class="ms-value">{{ $contact->name }}</div>
        </div>
        <div class="ms-field">
          <span class="ms-label">Email</span>
          <div class="ms-value"><a class="ms-mail" href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></div>
        </div>
        <div class="ms-field">
          <span class="ms-label">Received</span>
          <div class="ms-value"><span class="ms-chip-date">{{ $contact->created_at }}</span></div>
        </div>
      </div>

      <div class="ms-message">
        <span class="ms-label">Message</span>
        <pre class="pre-wrap">{{ $contact->message }}</pre>
      </div>
    </div>
  </div>

  <!-- Tiny scoped helper: copy email -->
  <script>
    (function(){
      const btn = document.getElementById('copyEmailBtn');
      if(!btn) return;
      btn.addEventListener('click', async () => {
        const email = btn.getAttribute('data-email') || '';
        try{
          await navigator.clipboard.writeText(email);
          btn.textContent = 'Copied!';
          setTimeout(() => btn.textContent = 'Copy Email', 1200);
        }catch(e){
          alert('Could not copy email.');
        }
      });
    })();
  </script>
</div>
@endsection
