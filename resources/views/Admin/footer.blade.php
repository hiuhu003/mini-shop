<footer class="mt-auto bg-black text-red-100 border-t border-red-900/60">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-3
              flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
    <p class="text-sm">&copy; {{ date('Y') }} Mini-Shop Admin</p>

    <ul class="flex flex-wrap gap-3 text-sm">
      <li><a href="{{ route('admin.settings') }}" class="hover:text-red-400">Settings</a></li>
      <li><a href="{{ route('admin.reports.index') }}" class="hover:text-red-400">Reports</a></li>
      <li><a href="{{ url('/') }}" class="hover:text-red-400">Storefront</a></li>
    </ul>


  </div>
</footer>
