<br>
{{ $welcome_text }}
<br>
@if ($a == 5):
echo "a égale 5";
echo "...";
@elseif ($a == 6):
echo "a égale 6";
echo "!!!";
@elseif ($a == 7):
echo "a égale 7";
echo "!!!";
@elseif ($a == 8):
echo "a égale 8";
echo "!!!";
@elseif ($a == 9):
echo "a égale 9";
echo "!!!";
@elseif ($a == 10):
echo "a égale 10";
echo "!!!";
@else:
echo "a ne vaut ni 5 ni 6";
@endif;
<br>
<br>
{{ $middle_text }}
<br>
@if ($b == 13):
echo "b égale 13";
echo "...";
@elseif ($b == 6):
echo "b égale 6";
echo "!!!";
@else:
echo "b ne vaut ni 5 ni 6";
@endif;
<br>
@foreach ($this->users as $user)
<p>This is user {$user['id']} comment: {$user['content']}</p>
@endforeach
<br>
{{ $end_text }}
<br>
<br>




<br>
{{ $welcome_text }}
<br>
@if ($a == 5):
echo "a égale 5";
echo "...";
@elseif ($a == 6):
echo "a égale 6";
echo "!!!";
@elseif ($a == 7):
echo "a égale 7";
echo "!!!";
@elseif ($a == 8):
echo "a égale 8";
echo "!!!";
@elseif ($a == 9):
echo "a égale 9";
echo "!!!";
@elseif ($a == 10):
echo "a égale 10";
echo "!!!";
@else:
echo "a ne vaut ni 5 ni 6";
@endif;
<br>
<br>
{{ $middle_text }}
<br>
@if ($b == 13):
echo "b égale 13";
echo "...";
@elseif ($b == 6):
echo "b égale 6";
echo "!!!";
@else:
echo "b ne vaut ni 5 ni 6";
@endif;
<br>
@foreach ($this->comments[0]['comment'] as $comment)
<p>This is user {$comment['id']} comment: {$user['content']}</p>
@endforeach
<br>
{{ $end_text }}
<br>
<br>