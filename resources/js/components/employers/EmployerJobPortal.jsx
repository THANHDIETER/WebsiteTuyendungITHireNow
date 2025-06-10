export default function EmployerJobPortal() {
    const jobs = [
        {
            title: "Senior Backend Developer",
            company: "ABC Corp",
            location: "Hà Nội",
            type: "Full-time",
            posted: "2 ngày trước",
            tags: ["Laravel", "REST API"]
        }
    ];

    return (
        <div>
            <h3>Việc làm đã đăng</h3>
            {jobs.map((job, i) => (
                <div key={i}>
                    <h4>{job.title}</h4>
                    <p>{job.company} - {job.location} - {job.type}</p>
                    <p>{job.posted}</p>
                    {job.tags.map((tag, i) => (
                        <span key={i}>{tag} </span>
                    ))}
                </div>
            ))}
        </div>
    );
}
