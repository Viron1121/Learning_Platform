<template>
  <section class="p-6 bg-gray-50 rounded-xl max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">New Research Project</h2>

    <!-- Project Info -->
    <div class="mb-6">
      <label class="block font-medium">Project Name</label>
      <input v-model="project.name" class="border rounded p-2 w-full" />

      <label class="block font-medium mt-4">Description</label>
      <textarea v-model="project.description" class="border rounded p-2 w-full"></textarea>

      <label class="block font-medium mt-4">Status</label>
      <select v-model="project.status" class="border rounded p-2 w-full">
        <option>In Progress</option>
        <option>Review</option>
        <option>Completed</option>
      </select>

      <label class="block font-medium mt-4">Due Date</label>
      <input type="date" v-model="project.due_date" class="border rounded p-2 w-full" />
    </div>

    <!-- Questions -->
    <div v-for="(q, qIndex) in project.questions" :key="qIndex" class="mb-6 p-4 bg-white rounded shadow">
      <div class="flex justify-between items-center mb-2">
        <label class="font-medium">Question {{ qIndex + 1 }}</label>
        <button @click="removeQuestion(qIndex)" class="text-red-500">Remove</button>
      </div>
      <input v-model="q.text" class="border rounded p-2 w-full mb-2" placeholder="Enter question text" />

      <!-- Choices -->
      <div v-for="(c, cIndex) in q.choices" :key="cIndex" class="flex items-center gap-2 mb-2">
        <input v-model="c.choice_text" placeholder="Choice text" class="border rounded p-2 flex-1" />
        <label class="flex items-center gap-1">
          <input type="checkbox" v-model="c.is_correct" />
          Correct
        </label>
        <button @click="removeChoice(qIndex, cIndex)" class="text-red-500">x</button>
      </div>

      <button @click="addChoice(qIndex)" class="bg-blue-500 text-white px-2 py-1 rounded text-sm">
        Add Choice
      </button>
    </div>

    <button @click="addQuestion" class="bg-green-500 text-white px-4 py-2 rounded mb-6">Add Question</button>

    <div>
      <button @click="submitProject" class="bg-blue-600 text-white px-6 py-2 rounded">Create Project</button>
    </div>
  </section>
</template>

<script setup>
import { reactive } from "vue";
import api from "../../api";
import { useRouter } from "vue-router";

const project = reactive({
  name: "",
  description: "",
  status: "In Progress",
  due_date: "",
  questions: [],
});

const router = useRouter();

function addQuestion() {
  project.questions.push({
    text: "",
    choices: [],
  });
}

function removeQuestion(index) {
  project.questions.splice(index, 1);
}

function addChoice(qIndex) {
  project.questions[qIndex].choices.push({
    choice_text: "",
    is_correct: false,
  });
}

function removeChoice(qIndex, cIndex) {
  project.questions[qIndex].choices.splice(cIndex, 1);
}

async function submitProject() {

  for (let i = 0; i < project.questions.length; i++) {
    const question = project.questions[i];
    const hasCorrect = question.choices.some(c => c.is_correct);
    if (!hasCorrect) {
      alert(`Question ${i + 1} must have at least 1 correct choice.`);
      return; // stop submission
    }
  }

  try {
    const payload = {
      ...project,
      questions: project.questions.map(q => ({
        text: q.text,
        choices: q.choices,
      })),
    };

    await api.post("/projects", payload);
    alert("Project created!");
    router.push({ name: "Dashboard" });

  } catch (err) {
    console.error(err);
    alert("Failed to create project");
  }
}

</script>
