@extends('admin.layout')
@section('title','Contact Messages')
@section('content')

<div class="admin-messages"><!-- SCOPE WRAPPER -->
  <style>
    /* Page-scoped tokens */
    .admin-messages{
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

    .admin-messages .am-wrap{ padding: clamp(12px,1.8vw,20px); background: var(--bg); color: var(--text); }
    .admin-messages .am-card{
      background: var(--surface); border:1px solid var(--border); border-radius: var(--radius);
      box-shadow: var(--shadow); padding: clamp(16px,2vw,22px);
    }

    .admin-messages .am-head{
      display:flex; align-items:flex-end; justify-content:space-between; gap:12px; flex-wrap:wrap;
      margin-bottom: 12px;
    }
    .admin-messages .am-title{ margin:0; font-weight:800; letter-spacing:.2px; }
    .admin-messages .am-subtitle{ margin:0; color:var(--muted); }

    .admin-messages .am-toolbar{ display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
    .admin-messages .am-input{
      background:#fff; border:1px solid var(--border); border-radius:10px; padding:10px 12px;
      box-shadow: var(--shadow-sm); color:var(--text); min-width: 220px;
    }

    .admin-messages .am-empty{
      border:1px dashed var(--border); border-radius:12px; background:var(--surface-2);
      padding:22px; color:var(--muted); text-align:center; box-shadow: var(--shadow-sm);
      margin-top: 8px;
    }

    /* Table */
    .admin-messages .am-table-wrap{
      margin-top: 8px; border:1px solid var(--border); border-radius: 12px; overflow: hidden;
      background: var(--surface); box-shadow: var(--shadow);
    }
    .admin-messages .am-table{ width:100%; border-collapse: separate; border-spacing:0; font-size:.96rem; }
    .admin-messages .am-table thead th{
      text-align:left; padding:12px 14px; background:#fff; border-bottom:1px solid var(--border);
      color:var(--muted); font-weight:800;
    }
    .admin-messages .am-table tbody td{
      padding:12px 14px; border-bottom:1px solid var(--border); vertical-align: middle;
    }
    .admin-messages .am-table tbody tr:nth-child(even){ background: var(--surface-2); }
    .admin-messages .am-table tbody tr:hover{ background:#fff; }

    .admin-messages .am-col-id{ width:80px; color:var(--muted); }
    .admin-messages .am-col-actions{ width:180px; text-align:right; white-space: nowrap; }

    /* Date chip + mail link */
    .admin-messages .am-chip-date{
      display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:999px;
      background:#ecfeff; color:#155e75; border:1px solid #cffafe; font-weight:700; font-size:.85rem;
    }
    .admin-messages .am-mail{ color: var(--primary); text-decoration: none; }
    .admin-messages .am-mail:hover{ text-decoration: underline; }

    /* Buttons */
    .admin-messages .am-btn{
      appearance:none; border:1px solid var(--border); border-radius: 999px;
      padding: 8px 12px; font-weight:700; text-decoration:none; cursor:pointer;
      display:inline-flex; align-items:center; gap:.5rem; transition:.18s ease;
      background:#fff; color:var(--text); box-shadow: var(--shadow-sm);
    }
    .admin-messages .am-btn:hover{ transform: translateY(-1px); box-shadow: var(--shadow); }
    .admin-messages .am-btn:focus-visible{ outline:3px solid var(--ring); outline-offset:2px; }
    .admin-messages .am-btn-sm{ padding:8px 10px; border-radius:10px; }

    /* Pagination wrap (keeps default Laravel links styling intact) */
    .admin-messages .am-pagination{ margin-top:12px; display:flex; justify-content:flex-end; }

    /* Responsive stack */
    @media (max-width: 960px){
      .admin-messages .am-table-wrap{ border-radius:10px; }
      .admin-messages .am-table,
      .admin-messages .am-table thead,
      .admin-messages .am-table tbody,
      .admin-messages .am-table th,
      .admin-messages .am-table td,
      .admin-messages .am-table tr{ display:block; }
      .admin-messages .am-table thead{ display:none; }
      .admin-messages .am-table tbody tr{ border-bottom:1px solid var(--border); padding:8px 12px; }
      .admin-messages .am-table tbody td{
        border:none; padding:8px 0; display:grid; grid-template-columns: 120px 1fr; gap:8px;
      }
      .admin-messages .am-table tbody td::before{
        content: attr(data-label); font-weight:700; color:var(--muted);
      }
      .admin-messages .am-col-actions{ width:auto; text-align:left; }
    }
  </style>

  <div class="am-wrap">
    <div class="am-card">
      <div class="am-head">
        <div>
          <h1 class="am-title">Contact Messages</h1>
          <p class="am-subtitle">View and respond to inbound messages.</p>
        </div>

        <!-- Optional UI-only toolbar; remove if not needed -->
        <div class="am-toolbar" role="group" aria-label="UI-only tools">
          <input class="am-input" type="search" placeholder="Search name or email…" aria-label="Search (UI only)">
        </div>
      </div>

      @if ($rows->isEmpty())
        <div class="am-empty">No messages.</div>
      @else
        <div class="am-table-wrap" role="region" aria-label="Contact messages table">
          <table class="am-table">
            <thead>
              <tr>
                <th class="am-col-id">ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Received</th>
                <th class="am-col-actions">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($rows as $r)
                <tr>
                  <td class="am-col-id" data-label="ID">#{{ $r->id }}</td>
                  <td data-label="Name"><strong>{{ $r->name }}</strong></td>
                  <td data-label="Email"><a class="am-mail" href="mailto:{{ $r->email }}">{{ $r->email }}</a></td>
                  <td data-label="Received"><span class="am-chip-date">{{ $r->created_at }}</span></td>
                  <td class="am-col-actions" data-label="Action">
                    <a class="am-btn am-btn-sm" href="{{ route('admin.messages.show', $r) }}">View</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        @if(method_exists($rows,'links'))
          <div class="am-pagination">{{ $rows->links() }}</div>
        @endif
      @endif
    </div>
  </div>
</div>

@endsection
