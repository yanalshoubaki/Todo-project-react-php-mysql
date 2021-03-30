import React, { useState } from "react";
import axios from "axios";

const AddTask = (props) => {
  const [task, setTask] = useState({ task_name: "" });
  const handleSubmit = (e) => {
    e.preventDefault();
    if (task.task_name === "") return;
    props.onFormSubmit(task.task_name);
    axios({
      url:
        "http://localhost/todo-project-react-php-mysql/api/v1/todoapi/todo.php",
      method: "POST",
      data: {
        action: "add",
        task_name: task.task_name,
      },
    })
      .then((response) => {
        console.log(response);
      })
      .catch((error) => {
        console.log(error);
      });
    setTask({ task_name: "" });
  };
  return (
    <form onSubmit={handleSubmit}>
      <input
        type="text"
        className="input"
        placeholder="Enter Task"
        value={task.task_name}
        onChange={(e) => setTask({ task_name: e.target.value })}
      />
      <button className="button">Submit</button>
    </form>
  );
};

export default AddTask;
