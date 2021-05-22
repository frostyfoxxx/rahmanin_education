<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('qualification_classifier_id')->comment('Айди из классификатора');
            $table->integer('ft_budget_quota')->comment('Кол-во бюджетных мест на очном формате обучения');
            $table->integer('rm_budget_quota')->comment('Кол-во бюджетных мест на заочном');
            $table->boolean('working_profession')->comment('Рабочая профессия');
            $table->boolean('budget')->comment('Bool бюджета');
            $table->boolean('commercial')->comment('Bool Коммерции');
            $table->timestamps();
            $table->foreign('qualification_classifier_id')->references('id')->on('qualification_classifiers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qualifications');
    }
}
