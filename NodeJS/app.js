var port = 8000;
var express = require("express");
const app = express();
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static("static-content"));
let questions = {
  "Are you the best?": { yes: 0, no: 0 },
  "How is your day?": { yes: 0, no: 0 }
};

app.get("/questions", (req, res) => {
  res.json(questions);
});

app.post("/add_question", (req, res) => {
  const { question, options } = req.body;
  if (!question || !options) {
    return res.status(400).json({ message: "missing fields" });
  }
  questions[question] = {};
  options.forEach((option) => {
    questions[question][option] = 0;
  });
  res.json({ message: "success" });
});

// Change the counter for a question
app.put("/respond", (req, res) => {
  const { question, option } = req.body;
  if (!questions.hasOwnProperty(question) || !questions[question].hasOwnProperty(option)) {
    return res.status(404).json({ message: "resource not found" });
  }

  questions[question][option]++;
  res.json({ message: "success" });
});

app.listen(port, () => {
  console.log(`Running on ${port}`);
});
