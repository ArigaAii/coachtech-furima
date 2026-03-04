```mermaid
erDiagram

  users ||--o{ items : "lists"
  users ||--o{ likes : "likes"
  users ||--o{ comments : "writes"
  users ||--o{ purchase_histories : "buys"

  items ||--o{ likes : "liked_by"
  items ||--o{ comments : "has"
  items ||--o{ purchase_histories : "purchased_in"

  items ||--o{ item_item_categories : "categorized_as"
  item_categories ||--o{ item_item_categories : "has"

  users {
    bigint id PK
    varchar name
    varchar postcode
    varchar address
    varchar building_name
    varchar profile_image
    varchar email UK
    tinyint profile_completed
    timestamp email_verified_at
    varchar password
    text two_factor_secret
    text two_factor_recovery_codes
    timestamp two_factor_confirmed_at
    varchar remember_token
    timestamp created_at
    timestamp updated_at
  }

  items {
    bigint id PK
    bigint user_id FK
    varchar name
    varchar brand_name
    varchar status
    tinyint is_sold
    bigint shop_id
    int price
    text description
    varchar image_path
    int likes_count
    int comments_count
    timestamp created_at
    timestamp updated_at
  }

  item_categories {
    bigint id PK
    varchar name
    timestamp created_at
    timestamp updated_at
  }

  item_item_categories {
    bigint id PK
    bigint item_category_id FK
    bigint item_id FK
    timestamp created_at
    timestamp updated_at
  }

  purchase_histories {
    bigint id PK
    bigint user_id FK
    bigint item_id FK
    varchar postcode
    varchar address
    varchar building_name
    varchar payment_method
    varchar status
    timestamp created_at
    timestamp updated_at
  }

  likes {
    bigint id PK
    bigint user_id FK
    bigint item_id FK
    timestamp created_at
    timestamp updated_at
  }

  comments {
    bigint id PK
    bigint user_id FK
    bigint item_id FK
    text body
    timestamp created_at
    timestamp updated_at
  }
```
### 制約メモ（DB仕様）
- likes：UNIQUE(user_id, item_id)
- item_item_categories：UNIQUE(item_category_id, item_id)
- 外部キー
  - items.user_id → users.id
  - likes.user_id → users.id / likes.item_id → items.id
  - comments.user_id → users.id / comments.item_id → items.id
  - purchase_histories.user_id → users.id / purchase_histories.item_id → items.id
  - item_item_categories.item_id → items.id / item_item_categories.item_category_id → item_categories.id