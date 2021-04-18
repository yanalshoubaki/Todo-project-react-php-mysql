import React, { Component } from "react";
import axios from "axios";
import "./styles/App.css";
import Header from "./components/Header";
import Tasks from "./components/Tasks";
import AddTask from "./components/AddTask";
import DarkMode from "./components/DarkMode";
const URL = `http://localhost/todo-project-react-php-mysql/api/v1/todoapi/todo.php`;
class App extends Component {
  state = {
    tasks: [],
    update: [{ task_id: null, edit: false }],
  };

  getData = () => {
    axios({
      url: URL,
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => {
        this.setState({ tasks: [...response.data.data] });
      })
      .catch((error) => {
        console.log(error);
      });
  };
  handleSubmit = (task) => {
    this.setState({
      tasks: [
        ...this.state.tasks,
        {
          task_id:
            this.state.tasks.length > 0
              ? parseInt(
                  this.state.tasks[this.state.tasks.length - 1].task_id
                ) + 1
              : 1,
          task_name: task,
        },
      ],
    });
  };
  handleDelete = (task_id) => {
    axios({
      url: URL,
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      data: {
        action: "delete",
        task_id: task_id,
      },
    })
      .then((response) => {})
      .catch((error) => {});
    const array = this.state.tasks.filter((task) => {
      if (task.task_id !== task_id) {
        return { ...task };
      }
    });
    this.setState({ tasks: [...array] });
  };
  handleCheck = (task) => {
    axios({
      url: URL,
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      data: {
        action: task.task_status ? "done" : "not_done",
        task_id: task.task_id,
        task_status: task.task_status ? 1 : 0,
      },
    })
      .then((response) => {
        this.state.tasks.filter((taske) => {
          if (taske.task_id === task.task_id) {
            taske.task_status = task.task_status ? 1 : 0;
            console.log(taske.task_status);
          }
        });
      })
      .catch((error) => {
        console.log(error);
      });
  };
  handleUpdate = (data) => {
    console.log(data);
    var index = this.state.tasks.findIndex((x) => x.task_id === data.task_id);
    if (index === -1) {
    } else {
      this.state.tasks.map((task) => {
        if (task.task_id === data.task_id) {
          if (data.task_name === task.task_name || data.task_name === "") {
            this.setState({ update: { task_id: null, edit: false } });
          } else {
            axios({
              url: URL,
              method: "POST",
              headers: {
                "Content-Type": "application/json",
              },
              data: {
                action: "update",
                task_id: task.task_id,
                task_name: data.task_name,
              },
            })
              .then((response) => {
                console.log(response);
                this.setState({ update: { task_id: null, edit: false } });
              })
              .catch((error) => {
                console.log(error);
              });
          }
        }
      });
    }
  };
  handleEdit = (data) => {
    this.setState({ update: { task_id: data, edit: true } });
  };
  componentDidMount() {
    this.getData();
  }
  componentDidUpdate() {
    this.getData();
  }
  render() {
    return (
      <div className="wrapper">
        <DarkMode />
        <div className="card frame">
          <Header numTodos={this.state.tasks.length} />
          <Tasks
            tasks={this.state.tasks}
            editMode={this.state.update}
            onDelete={this.handleDelete}
            onCheck={this.handleCheck}
            onUpdate={this.handleUpdate}
            onEdit={this.handleEdit}
          />
          <AddTask onFormSubmit={this.handleSubmit} />
        </div>
      </div>
    );
  }
}

export default App;
