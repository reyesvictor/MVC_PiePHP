<br>
@isset( $this->users )
<p>Ce isset fonctionne {$users->email} c'est cool</p>
<p>Ce isset fonctionne {$a} c'est cool</p>
@isset( $inconnu )
<p>Ce isset ne fonctionne pas les mecs</p>
@endisset
@empty( $vide )
<p>Cette variable $ vide est vide</p>
@endempty
{{ $welcome_text }}
<br>
@isset ( $a )
@if ($a == 5)
echo "a égale 5";
echo "...";
@elseif ($a == 6)
echo "a égale 6";
echo "!!!";
@elseif ($a == 7)
echo "a égale 7";
echo "!!!";
@elseif ($a == 8)
echo "a égale 8";
echo "!!!";
@elseif ($a == 9)
echo "a égale 9";
echo "!!!";
@elseif ($a == 10)
echo "a égale 10";
echo "!!!";
@else
echo "a ne vaut ni 5 ni 6";
<br>
{{ $welcome_text }}
@endif
@endisset
<br>
@isset ( $users->comments[0]->comment['content'] )
<p>The user {$users->email}, had a {$users->promos[0]->promo['content']} reduction<br>
@endisset
@isset ( $users->promo_id )
<p>The user {$users->email}, had a reduction, id : {$users->promo_id}<br>
@endisset
<br>
<br>
{{ $middle_text }}
<br>
@if ($b == 13)
echo "b égale 13";
echo "...";
@elseif ($b == 6)
echo "b égale 6";
echo "!!!";
@else
echo "b ne vaut ni 5 ni 6";
@endif
<br>
@isset ( $users->comments[0]->comment['content'] )
@foreach ($users->comments[0]->comment as $comment)
<p>This is user comments is as follows: {$comment['content']}</p>
@endforeach
@endisset
<br>
<br>
@isset ( $users->games[0]->game['content'] )
@foreach ($users->games[0]->game as $game)
<p>The user {$game['user_id']} played: {$game['content']}</p>
@endforeach
@endisset
<br>
@endisset
{{ $end_text }}
<br>
{{ $credits }}
<br>