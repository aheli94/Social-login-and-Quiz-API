<h1><?php echo $title ?></h1>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div id="message"></div>
        <?php echo form_open('http://localhost/codeigniter/ci-php-webapi/index.php/pages/quizSubmit', array('id' => 'quizForm')) ?>
        <div class="form-group">
            <input type="text" name="question_set" id="question_set" class="form-control" placeholder="Question set">
        </div>
        <div class="form-group">
            <input type="text" name="questions" id="questions" class="form-control" placeholder="Questions">
        </div>
        <div class="form-group">
            <input type="text" name="option1" id="option1" class="form-control" placeholder="Option1">
        </div>
        <div class="form-group">
            <input type="text" name="option2" id="option2" class="form-control" placeholder="Option2">
        </div>
        <div class="form-group">
            <input type="text" name="option3" id="option3" class="form-control" placeholder="Option3">
        </div>
        <div class="form-group">
            <input type="text" name="option4" id="option4" class="form-control" placeholder="Option4">
        </div>
        <div class="form-group">
            <input type="text" name="answer" id="answer" class="form-control" placeholder="Answer">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info">Submit</button>
        </div>
        <?php echo form_close() ?>
    </div>
</div>

<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

<script>
    $(function() {
        $("#quizForm").on('submit', function(e) {
            e.preventDefault();

            var quizForm = $(this);

            $.ajax({
                url: quizForm.attr('action'),
                type: 'post',
                data: quizForm.serialize(),
                success: function(response){
                    console.log(response);
                    if(response.status == 'success') {
                        $("#quizForm").hide();
                    }

                    $("#message").html(response.message);

                }
            });
        });
    });
</script>