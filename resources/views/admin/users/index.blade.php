@extends('admin.layout')
@section('title','Users')
@section('content')
<div class="grid">
  <div class="col-12">
    <div class="card">
      <div style="display:flex; align-items:center; justify-content:space-between; gap:12px">
        <div>
          <h2>Users</h2>
          <p class="help">List of all registered users.</p>
        </div>
        <div class="help">Total: <span class="badge">{{ $users->count() }}</span></div>
      </div>

      @if($users->isEmpty())
        <div class="empty">No users found.</div>
      @else
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Created</th><th>Actions</th>
              </tr>
            </thead>
            <tbody>
            @foreach($users as $u)
              <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>
                  @if(($u->role ?? '') === 'admin')
                    <span class="badge admin">Admin</span>
                  @else
                    <span class="badge">{{ $u->role }}</span>
                  @endif
                </td>
                <td>{{ $u->created_at }}</td>
                <td>
                  @if(auth()->id() !== $u->id)
                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Delete user?')" style="display:inline">
                      @csrf @method('DELETE')
                      <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                    </form>
                  @else
                    <span class="help">You</span>
                  @endif
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      @endif

      <div style="margin-top:14px">
        <a href="{{ route('admin.index') }}" class="btn btn-ghost">Back</a>
      </div>
    </div>
  </div>
</div>
@endsection
