# Email Preview

Required components:
- Profiler
- Mailer

## Send email

- Set `MAILER_DNS` in `.env.local` file
- Start Symfony server: `symfony server:run`
- Visit `http://localhost:8000/email-preview/send`
- See email preview in the profiler