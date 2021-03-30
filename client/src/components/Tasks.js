import React, { useState } from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTrash, faPen } from "@fortawesome/free-solid-svg-icons";
const TodoEdit = (props) => {
  console.log(props);
  const [taskName, SetTaskName] = useState("");
  return (
    <div className="list-item">
      <input
        className="edit-input"
        type="text"
        defaultValue={props.content.task_name}
        onChange={(e) => SetTaskName(e.target.value)}
      />
      <button
        className="edit-button"
        onClick={(e) => {
          e.preventDefault();
          console.log(taskName);
          props.onUpdate({
            task_id: props.content.task_id,
            task_name: taskName,
          });
        }}
      >
        edit
      </button>
    </div>
  );
};
const TodoPreview = (props) => {
  return (
    <div
      className="list-item"
      className={
        parseInt(props.content.task_status) === 1 ? "completed" : "no-completed"
      }
    >
      <input
        type="checkbox"
        defaultChecked={
          parseInt(props.content.task_status) === 1 ? true : false
        }
        onClick={(e) => {
          console.log(e.target.checked);
          props.onCheck({
            task_id: props.content.task_id,
            task_status: e.target.checked,
          });
        }}
      />
      <label>{props.content.task_name}</label>
      <button
        className="delete is-pulled-right"
        onClick={() => {
          props.onDelete(props.content.task_id);
        }}
      >
        <FontAwesomeIcon icon={faTrash} />
      </button>
      <button
        className="edit is-pulled-right"
        onClick={() => {
          props.onEdit(props.content.task_id);
        }}
      >
        <FontAwesomeIcon icon={faPen} />
      </button>
    </div>
  );
};

const Tasks = (props) => {
  const todos = props.tasks.map((todo) => {
    if (props.editMode.task_id === todo.task_id) {
      return (
        <TodoEdit
          content={todo}
          taskName={todo.task_name}
          key={todo.task_id}
          task_id={todo.task_id}
          onDelete={props.onDelete}
          onCheck={props.onCheck}
          onUpdate={props.onUpdate}
        />
      );
    } else {
      return (
        <TodoPreview
          content={todo}
          key={todo.task_id}
          task_id={todo.task_id}
          onDelete={props.onDelete}
          onCheck={props.onCheck}
          onUpdate={props.onUpdate}
          onEdit={props.onEdit}
        />
      );
    }
  });
  return <div className="list-wrapper">{todos}</div>;
};
export default Tasks;
