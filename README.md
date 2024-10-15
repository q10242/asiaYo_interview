

# OrderInsert 策略模式說明

在 **OrderInsert** 的策略模式中，`OrderInsertFactory` 根據不同的 `currency`，選擇建立不同的子類別來插入資料。這是典型的策略模式實現。

## 1. 單一職責原則
每一個策略都只負責一件事，即針對特定的 `currency` 插入訂單資料。每個策略類別專注於其自身的處理邏輯，因此完全符合單一職責原則。

## 2. 開放/封閉原則
當需要支持新增的貨幣種類時，無需修改原來的策略邏輯。只需要新增對應的策略類別即可，系統對修改封閉、對擴展開放。

## 3. 里氏替換原則
所有的策略類別都依賴於 `OrderInsert` 的 interface，因此它們可以在 `OrderInsertFactory` 中互相替換而不影響系統運行。

## 4. 介面隔離原則
`OrderInsertFactory` 回傳的是依賴於 `OrderInsert` 的 interface，而不需要知道具體的子類別。這符合介面隔離原則，避免依賴過多的細節實現。

## 5. 依賴倒轉原則
`OrderInsertFactory` 中的 `currency` 是外部傳入的參數，並非硬編碼的依賴。因此，`OrderInsertFactory` 依賴於抽象（`currency`）而不是具體的實現，符合依賴倒轉原則。
