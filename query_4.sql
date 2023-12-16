SELECT meal.meal_name, diet_plan.diet_plan_type
FROM diet_plan JOIN meal ON diet_plan.meal_id = meal.meal_id
WHERE meal.calories IN 
	(SELECT MAX(calories) FROM meal)