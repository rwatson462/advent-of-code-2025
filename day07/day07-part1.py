
def read_file(filename):
    with open(filename) as file:
        return [[col for col in row.strip()] for row in file]

grid = read_file("real-input")

LASER="S"
SPLITTER="^"
SPACE="."

splits = 0
for rowIdx in range(1, len(grid) - 1):
    row = grid[rowIdx]
    for colIdx in range(len(row)):
       if grid[rowIdx-1][colIdx] == LASER:
           if row[colIdx] == SPLITTER:
               grid[rowIdx][colIdx-1] = LASER
               grid[rowIdx][colIdx+1] = LASER
               splits += 1
           if row[colIdx] == SPACE:
               row[colIdx] = LASER

print("Answer: ", splits)
