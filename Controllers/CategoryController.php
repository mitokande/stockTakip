<?php 

namespace Controllers;
require_once("vendor/autoload.php");
require_once("ApiConfig.php");

use Entities\Category;
use Utilities\Result\DataResult;
use Utilities\Result\SuccessDataResult;

class CategoryController{


    function addCategory($categoryFormId,$categoryName): DataResult{
        $submission = array(
            "3" => $categoryName
        );
        $result = getApi()->createFormSubmission($categoryFormId, $submission);
        return new SuccessDataResult($result,"Category added Successfuly");
    }

    function getCategories($categoryFormId): DataResult
    {
        $categoriesRow = getApi()->getFormSubmissions($categoryFormId);
        $categories = [];
        foreach ($categoriesRow as $categoryRow) {
            if ($categoryRow['status'] == "ACTIVE") {
                $category = new Category();
                $category->categoryName = $categoryRow['answers'][3]['answer'];
                $category->categoryDate = $categoryRow['created_at'];

                $categories[] = $category;
            }
        }
        $result = new SuccessDataResult($categories, "Categories listed successfully");
        return $result;
        exit();
    }


}



?>