<?hh

async function block() {
  await RescheduleWaitHandle::create(0, 0);
}

async function foo($a) {
  $fn = async ($b) ==> {
    $c = 0;
    while (true) {
      await block();
      yield $a * $b + $c;
      ++$c;
    }
  };

  $gen = $fn(47, 26);
  do {
    $next = await $gen->next();
    $next = $next[1];
    echo "$next\n";
  } while ($next < 2000);
}

foo(42)->join();
