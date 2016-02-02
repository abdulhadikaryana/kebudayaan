<?php

class Lamanbudaya_Form_Decorator_Polling
        extends Zend_Form_Decorator_Abstract
{
  public function render($content)
  {
    $messages = $this->getElement()->getErrorMessages();
    $list_msg = '';
    if (!empty($messages)) {
      $list_msg = '<ul>';
      foreach ($messages as $messages) {
        $list_msg .= "<li>{$messages}</li>";
      }
      $list_msg.='</ul>';
    }
    $markup = <<<HTML
      <div id="answer-container">
          <input type="text"
                 id="answer"
                 onkeypress="handleEnter()" 
                 placeholder="Masukkan jawaban"
                 style="margin:0"/>
          <a class="btn btn-success" onclick="add()">Tambah Jawaban</a>
          <br /><br />
          {$list_msg}
            
            <ul id="answers-list">
              $content
            </ul>
          <script type="text/javascript">
          function handleEnter() {
            if(13 == event.keyCode) {
              add();
              event.preventDefault();
              return false;
            }
            
          }
        
          function add() {
            var answer = $("#answer").val();
            if('' == answer) {
              alert("Answer cannot be empty");
              return false;
            }
            list  = "<li>";
            list += '<label for="">'+answer+'</label>';
            list += '<input type="hidden" name="polling[answer][]" value="'+answer+'" />';
            list += '<a href="javascript:void(0)" onclick="$(this).parents(\'li\').remove()">Remove</a>';
            list += "</li>";
            
            $("#answers-list").append(list);
            $("#answer").val(null);
          }
        </script>
      </div>
HTML;

    return $markup;
  }

}
?>