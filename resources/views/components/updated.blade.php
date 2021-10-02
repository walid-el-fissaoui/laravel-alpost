<div class="text-muted">
  {{-- {{empty(trim($slot)) ? 'added : ' : $slot}}  {{ $date }}  {{ isset($name) ? ' , by ' . $name : null }} --}}
  {{-- {{ empty(trim($slot)) ? 'added : ' : $slot}}  {{ $date }}  {!! isset($name) ? ' , by <a href='.route('users.show',['user'=>$userId]).'>'.$name . '</a>' : null .'</a>' !!} --}}
  {{ empty(trim($slot)) ? 'added : ' : $slot}}  {{ $date }}  {{ isset($name) ? 'by ,' : null}} {!! isset($userId) ? '<a href='.route('users.show',['user'=>$userId]).'>'. $name . '</a>' : $name  !!}
</div>
