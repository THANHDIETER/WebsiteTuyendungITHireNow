<template>
  <div>
    <h2>📄 Danh sách công việc đã đăng</h2>
    <ul>
      <li v-for="job in jobs" :key="job.id">
        {{ job.title }} - {{ job.location }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'EmployerJobPortal',
  data() {
    return {
      jobs: []
    }
  },
  mounted() {
  console.log("Mounted run");
  fetch('/api/employer/jobs')
    .then(res => res.json())
    .then(data => {
      console.log("Fetched jobs:", data)
      this.jobs = data
    })
    .catch(err => {
      console.error('Fetch jobs error:', err)
    })
}

}

</script>
