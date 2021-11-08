# Profiler Parameter

Required components:
- Profiler

## Enable parameter with a parameter

- Disable profiler:

```
framework:
    profiler:
        collect: false # Disable collection by default 
        collect_parameter: profile # Enable it if the parameter is set
```

- Start Symfony server: `symfony server:run`
- Profiler is disabled by default: `http://localhost:8000/profiler-parameter`
- You can enable it using a parameter: `http://localhost:8000/profiler-parameter?profile=1`