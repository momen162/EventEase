@extends('admin.layout')
@section('title','Users')

@push('head')
<style>
  /* ----- Users page scoped styles ----- */
  .card.users {
    background: linear-gradient(180deg, rgba(255,255,255,.9), rgba(255,255,255,.96));
    border: 1px solid rgba(17,24,39,.06);
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(2,8,23,.08);
    padding: 22px;
  }
  .users-header{
    display:flex; align-items:center; justify-content:space-between; gap:12px;
  }
  .users-title{ margin:0 0 2px 0; font-size:1.35rem; letter-spacing:.2px }
  .users-sub{ margin:0; color:#6b7280 }
  .pill {
    display:inline-flex; align-items:center; gap:.5rem;
    padding:.35rem .7rem; border-radius:999px; font-weight:700; font-size:.9rem;
    background:#eef2ff; color:#4a6cf7; border:1px solid #e5e7eb;
  }

  /* Table shell */
  .table-wrap{
    margin-top:16px;
    border:1px solid #e5e7eb; border-radius:14px; overflow:hidden;
    background:#fff;
  }
  .table-scroll{
    overflow:auto;
    /* mobile friendly horizontal scroll */
  }
  table.users-table{ width:100%; border-collapse:separate; border-spacing:0 }
  .users-table thead th{
    position:sticky; top:0; z-index:1;
    background:linear-gradient(180deg, #f8fafc, #f1f5f9);
    color:#374151; text-align:left; font-size:.9rem; letter-spacing:.02em;
    border-bottom:1px solid #e5e7eb; padding:12px 14px;
  }
  .users-table tbody td{
    padding:12px 14px; border-bottom:1px solid #f1f5f9; color:#1f2937;
  }
  .users-table tbody tr:nth-child(even){ background:#fcfdff }
  .users-table tbody tr:hover{ background:#f7fbff }
  .users-table th:first-child, .users-table td:first-child{ padding-left:18px }
  .users-table th:last-child, .users-table td:last-child{ padding-right:18px }

  /* Badges */
  .badge{
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.25rem .55rem; border-radius:999px; font-size:.8rem; font-weight:700;
    background:#eef2ff; color:#4a6cf7; border:1px solid #e5e7eb;
  }
  .badge.admin{
    background:#ecfdf5; color:#059669; border-color:#d1fae5;
  }

  /* Buttons */
  .btn{ display:inline-flex; align-items:center; justify-content:center; gap:.45rem;
        height:40px; padding:0 .9rem; border-radius:10px; font-weight:700;
        border:1px solid #e5e7eb; background:#fff; color:#111827;
        text-decoration:none; cursor:pointer; transition:transform .06s ease, background .2s ease, border-color .2s ease, box-shadow .2s ease; }
  .btn:hover{ background:#f9fafb }
  .btn:active{ transform:translateY(1px) }
  .btn-ghost{ background:transparent }
  .btn-ghost:hover{ background:#f3f4f6 }
  .btn-danger{
    background:#fee2e2; color:#991b1b; border-color:#fecaca;
  }
  .btn-danger:hover{ background:#fde8e8 }
  .btn-sm{ height:34px; padding:0 .65rem; border-radius:9px; font-weight:700 }

  .empty{
    margin-top:14px; padding:18px; border:1px dashed #e5e7eb; border-radius:12px;
    background: #fafafa; color:#6b7280; text-align:center;
  }

  /* Small screens */
  @media (max-width: 800px){
    .users-header{ flex-direction:column; align-items:flex-start; gap:6px }
    .pill{ align-self:flex-start }
  }
</style>
@endpush

@section('content')
<div class="grid">
  <div class="col-12">
    <div class="card users">
      <div class="users-header">
        <div>
          <h2 class="users-title">Users</h2>
          <p class="users-sub">List of all registered users.</p>
        </div>
        <div class="pill">Total: {{ $users->count() }}</div>
      </div>

      @if($users->isEmpty())
        <div class="empty">No users found.</div>
      @else
        <div class="table-wrap">
          <div class="table-scroll">
            <table class="users-table">
              <thead>
                <tr>
                  <th style="width:80px">ID</th>
                  <th style="min-width:180px">Name</th>
                  <th style="min-width:220px">Email</th>
                  <th style="min-width:120px">Role</th>
                  <th style="min-width:160px">Created</th>
                  <th style="min-width:150px">Actions</th>
                </tr>
              </thead>
              <tbody>
              @foreach($users as $u)
                <tr>
                  <td>#{{ $u->id }}</td>
                  <td>{{ $u->name }}</td>
                  <td>{{ $u->email }}</td>
                  <td>
                    @if(($u->role ?? '') === 'admin')
                      <span class="badge admin">Admin</span>
                    @else
                      <span class="badge">{{ $u->role ?: '—' }}</span>
                    @endif
                  </td>
                  <td>{{ $u->created_at }}</td>
                  <td>
                    @if(auth()->id() !== $u->id)
                      <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Delete user?')" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit" title="Delete this user">
                          <!-- small trash icon -->
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true" style="margin-right:4px">
                            <path d="M9 3h6l1 2h4v2H4V5h4l1-2zM6 9h12l-1 10a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L6 9z" fill="#991b1b" opacity=".85"/>
                          </svg>
                          Delete
                        </button>
                      </form>
                    @else
                      <span class="users-sub">You</span>
                    @endif
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @endif

      <div style="margin-top:16px; display:flex; gap:10px">
        <a href="{{ route('admin.index') }}" class="btn btn-ghost">Back</a>
        {{-- If you use pagination later, drop controls here --}}
        {{-- <div class="pagination">{{ $users->links() }}</div> --}}
      </div>
    </div>
  </div>
</div>
@endsection
