<x-app-layout>
  <x-breadcrumb>
    Payments
    <li class="breadcrumb-item active" aria-current="page">Student Payments</li>
    <li class="breadcrumb-item active" aria-current="page">Invoice</li>
  </x-breadcrumb>

  <livewire:pages.accountant.payment-invoice :id="$student_id" :year="$year" />
</x-app-layout>