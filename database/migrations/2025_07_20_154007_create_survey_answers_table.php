<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('survey_answers', function (Blueprint $table) {
            $table->id();

            $answerColumn = $table->text('answer');
            if (Schema::getConnection()->getDriverName() === 'mysql') {
                $answerColumn->collation('utf8mb4_unicode_ci');
            }
            $table->unsignedBigInteger('question_id'); // FK to survey_questions
            $table->unsignedBigInteger('user_id'); // FK to users
            $table->index('question_id');
            $table->index('user_id');
            $table->unique(['user_id', 'question_id']); // Avoid duplicate responses


            $table->foreign('question_id')->references('id')->on('survey_questions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_answers');
    }
};
