# Doctrine streaming and batch processing

## Setup

- Run `make start` to initialize de web server
- Visit https://localhost:8000

## Examples

```
 --------------------------------- -------- -------- ------ ----------------------------------- 
  Name                              Method   Scheme   Host   Path                               
 --------------------------------- -------- -------- ------ ----------------------------------- 
  food_file_get_contents            GET      ANY      ANY    /food-file-get-contents            
  food_fopen                        GET      ANY      ANY    /food-fopen                        
  food_streamed_response            GET      ANY      ANY    /food-streamed                     
  food_streamed_response_logging    GET      ANY      ANY    /food-streamed-logging             
  food_streamed_response_doctrine   GET      ANY      ANY    /food-streamed-doctrine            
  food_binary                       GET      ANY      ANY    /food-binary                       
  food_bulk_insert_no_batch         GET      ANY      ANY    /food-bulk-insert-no-batch         
  food_bulk_insert_batch            GET      ANY      ANY    /food-bulk-insert-batch
```